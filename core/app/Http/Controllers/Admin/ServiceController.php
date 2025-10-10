<?php

namespace App\Http\Controllers\Admin;

use App\BasicExtended;
use App\BasicExtra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service;
use App\Scategory;
use App\Language;
use App\Megamenu;
use App\ServiceInput;
use App\ServiceInputOption;
use App\ServiceRequest;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use PHPMailer\PHPMailer\PHPMailer;

class ServiceController extends Controller
{

    public function settings()
    {
        $data['abex'] = BasicExtra::first();
        return view('admin.service.settings', $data);
    }

    public function updateSettings(Request $request)
    {
        $bexs = BasicExtra::all();
        foreach ($bexs as $bex) {
            $bex->service_category = $request->service_category;
            $bex->save();
        }

        return back()->with("success", "Settings updated successfully!");
    }

    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['services'] = Service::where('language_id', $lang_id)->withCount([
            "requests"=>function($query){
                $query->where('status',"Pending");
            }
        ])->orderBy('id', 'DESC')->get();

        $data['lang_id'] = $lang_id;
        $data['abe'] = BasicExtended::where('language_id', $lang_id)->first();

        return view('admin.service.service.index', $data);
    }

    public function edit($id)
    {
        $data['service'] = Service::findOrFail($id);
        $data['ascats'] = Scategory::where('status', 1)->where('language_id', $data['service']->language_id)->get();
        $data['abe'] = BasicExtended::where('language_id', $data['service']->language_id)->first();
        return view('admin.service.service.edit', $data);
    }

    public function store(Request $request)
    {
        $image = $request->image;
        $allowedExts = array('jpg', 'png', 'jpeg', 'svg');
        $extImage = pathinfo($image, PATHINFO_EXTENSION);

        $language = Language::find($request->language_id);
        $be = $language->basic_extended;

        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $slug = make_slug($request->title);

        $rules = [
            'language_id' => 'required',
            'image' => 'required',
            'title' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) use ($slug) {
                    $services = Service::all();
                    foreach ($services as $key => $service) {
                        if (strtolower($slug) == strtolower($service->slug)) {
                            $fail('The title field must be unique.');
                        }
                    }
                }
            ],
            'serial_number' => 'required',
            'content' => 'required',
            'details_page_status' => 'required',
            'summary' => 'required',
        ];
        if ($request->filled('image')) {
            $rules['image'] = [
                function ($attribute, $value, $fail) use ($extImage, $allowedExts) {
                    if (!in_array($extImage, $allowedExts)) {
                        return $fail("Only png, jpg, jpeg, svg image is allowed");
                    }
                }
            ];
        }

        // if 'theme version'contains service category
        if (serviceCategory()) {
            $rules["category"] = 'required';
        }

        // if 'theme version' doesn't contain service category
        if ($request->details_page_status == 0) {
            $rules["content"] = 'nullable';
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $service = new Service;
        $service->language_id = $request->language_id;
        $service->title = $request->title;

        if ($request->filled('image')) {
            $filename = uniqid() .'.'. $extImage;
            @copy($image, 'assets/front/img/services/' . $filename);
            $service->main_image = $filename;
        }

        $service->slug = $slug;
        // if 'theme version'contains service category
        if (serviceCategory()) {
            $service->scategory_id = $request->category;
        }
        $service->summary = $request->summary;
        $service->details_page_status = $request->details_page_status;
        $service->meta_description = $request->meta_description;
        $service->meta_keywords = $request->meta_keywords;
        $service->serial_number = $request->serial_number;
        $service->content = str_replace(url('/') . '/assets/front/img/', "{base_url}/assets/front/img/", $request->content);
        $service->save();

        Session::flash('success', 'Service added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $slug = make_slug($request->title);
        $service = Service::findOrFail($request->service_id);
        $serviceId = $request->service_id;

        $image = $request->image;
        $allowedExts = array('jpg', 'png', 'jpeg', 'svg');
        $extImage = pathinfo($image, PATHINFO_EXTENSION);

        $language = Language::find($service->language_id);
        $be = $language->basic_extended;

        $rules = [
            'title' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) use ($slug, $serviceId) {
                    $services = Service::all();
                    foreach ($services as $key => $service) {
                        if ($service->id != $serviceId && strtolower($slug) == strtolower($service->slug)) {
                            $fail('The title field must be unique.');
                        }
                    }
                }
            ],
            'content' => 'required',
            'serial_number' => 'required',
            'details_page_status' => 'required',
            'summary' => 'required',
        ];

        if ($request->filled('image')) {
            $rules['image'] = [
                function ($attribute, $value, $fail) use ($extImage, $allowedExts) {
                    if (!in_array($extImage, $allowedExts)) {
                        return $fail("Only png, jpg, jpeg, svg image is allowed");
                    }
                }
            ];
        }

        if (serviceCategory()) {
            $rules["category"] = 'required';
        }

        if ($request->details_page_status == 0) {
            $rules["content"] = 'nullable';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $service->title = $request->title;
        $service->slug = $slug;
        if (serviceCategory()) {
            $service->scategory_id = $request->category;
        }
        $service->summary = $request->summary;
        $service->details_page_status = $request->details_page_status;
        $service->serial_number = $request->serial_number;
        $service->meta_keywords = $request->meta_keywords;
        $service->meta_description = $request->meta_description;
        $service->content = str_replace(url('/') . '/assets/front/img/', "{base_url}/assets/front/img/", $request->content);

        if ($request->filled('image')) {
            @unlink('assets/front/img/services/' . $service->main_image);
            $filename = uniqid() .'.'. $extImage;
            @copy($image, 'assets/front/img/services/' . $filename);
            $service->main_image = $filename;
        }

        $service->save();

        Session::flash('success', 'Service updated successfully!');
        return "success";
    }

    public function deleteFromMegaMenu($service) {
        // unset service from megamenu for service_category = 1
        $megamenu = Megamenu::where('language_id', $service->language_id)->where('category', 1)->where('type', 'services');
        if ($megamenu->count() > 0) {
            $megamenu = $megamenu->first();
            $menus = json_decode($megamenu->menus, true);
            $catId = $service->scategory->id;
            if (is_array($menus) && array_key_exists("$catId", $menus)) {
                if (in_array($service->id, $menus["$catId"])) {
                    $index = array_search($service->id, $menus["$catId"]);
                    unset($menus["$catId"]["$index"]);
                    $menus["$catId"] = array_values($menus["$catId"]);
                    if (count($menus["$catId"]) == 0) {
                        unset($menus["$catId"]);
                    }
                    $megamenu->menus = json_encode($menus);
                    $megamenu->save();
                }
            }
        }

        // unset service from megamenu for service_category = 0
        $megamenu = Megamenu::where('language_id', $service->language_id)->where('category', 0)->where('type', 'services');
        if ($megamenu->count() > 0) {
            $megamenu = $megamenu->first();
            $menus = json_decode($megamenu->menus, true);
            if (is_array($menus)) {
                if (in_array($service->id, $menus)) {
                    $index = array_search($service->id, $menus);
                    unset($menus["$index"]);
                    $menus = array_values($menus);
                    $megamenu->menus = json_encode($menus);
                    $megamenu->save();
                }
            }
        }
    }

    public function delete(Request $request)
    {
        $service = Service::findOrFail($request->service_id);
        @unlink('assets/front/img/services/' . $service->main_image);

        $this->deleteFromMegaMenu($service);

        $service->delete();

        Session::flash('success', 'Service deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $service = Service::findOrFail($id);
            @unlink('assets/front/img/services/' . $service->main_image);

            $this->deleteFromMegaMenu($service);

            $service->delete();
        }

        Session::flash('success', 'Services deleted successfully!');
        return "success";
    }

    public function getcats($langid)
    {
        $scategories = Scategory::where('language_id', $langid)->get();

        return $scategories;
    }

    public function feature(Request $request)
    {
        $service = Service::find($request->service_id);
        $service->feature = $request->feature;
        $service->save();

        if ($request->feature == 1) {
            Session::flash('success', 'Featured successfully!');
        } else {
            Session::flash('success', 'Unfeatured successfully!');
        }

        return back();
    }

    public function sidebar(Request $request)
    {
        $service = Service::find($request->service_id);
        $service->sidebar = $request->sidebar;
        $service->save();

        if ($request->sidebar == 1) {
            Session::flash('success', 'Enabled successfully!');
        } else {
            Session::flash('success', 'Disabled successfully!');
        }

        return back();
    }

    public function createForm(string $id) : View
    {
        $data['service'] = Service::findOrFail((int)$id);
        $data['serviceInputs'] = ServiceInput::where('service_id', $id)->orderBy('order', 'asc')->get();
        return view('admin.service.service.form.create', $data);
    }
    public function formStore(string $id,Request $request) : string|JsonResponse{
        $service = Service::findOrFail((int)$id);

        $inname = make_input_name($request->unique_name);
        $inputs = ServiceInput::where('service_id', $service->id)->get();

        $messages = [
            'options.*.required_if' => 'Options are required if field type is select dropdown/checkbox',
            'placeholder.required_unless' => 'The placeholder field is required unless field type is Checkbox or File'
        ];

        $rules = [
            'unique_name' => [
                'required',
                function ($attribute, $value, $fail) use ($inname, $inputs) {
                    foreach ($inputs as $key => $input) {
                        if ($input->name == $inname) {
                            $fail("Input field already exists.");
                        }
                    }
                },
            ],
            "label" => 'required',
            'placeholder' => 'required_unless:type,3,5,10',
            'type' => 'required',
            'options.*' => 'required_if:type,2,3'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        // Get the next order number
        $maxOrder = ServiceInput::where('service_id', $service->id)->max('order') ?? 0;
        
        $input = new ServiceInput;
        $input->service_id = $service->id;
        $input->type = $request->type;
        $input->label = $request->label;
        $input->name = $inname;
        $input->placeholder = $request->placeholder;
        $input->required = (int)$request->required;
        $input->order = $maxOrder + 1;
        $input->save();

        if ($request->type == 2 || $request->type == 3) {
            $options = $request->options;
            foreach ($options as $key => $option) {
                $op = new ServiceInputOption;
                $op->service_input_id = $input->id;
                $op->name = $option;
                $op->save();
            }
        }

        Session::flash('success', 'Input field added successfully!');
        return "success";
    }
    public function inputEdit(string $id) : View
    {
        $data['input'] = ServiceInput::findOrFail((int)$id);
        if (!empty($data['input']->input_options)) {
            $options = $data['input']->input_options;
            $data['options'] = $options;
            $data['counter'] = count($options);
        }
        $data['service'] = Service::findOrFail($data['input']->service_id);
        return view('admin.service.service.form.edit', $data);
    }
    public function inputUpdate(string $id,Request $request) : string|JsonResponse{
        $serviceInput = ServiceInput::findOrFail((int)$id);
        $serviceInput->update($request->all());
        Session::flash('success', 'Input field updated successfully!');
        return "success";
    }
    public function inputDelete(string $input_id) : RedirectResponse{
        $serviceInput = ServiceInput::findOrFail((int)$input_id);
        $serviceInput->active = !$serviceInput->active;
        $serviceInput->update();
        return back()->withSuccess('Input field active status updated successfully!');
    }

    public function updateInputOrder(Request $request) : JsonResponse
    {
        try {
            $order = $request->input('order');
            
            if (!is_array($order)) {
                return response()->json(['success' => false, 'message' => 'Invalid order data']);
            }

            foreach ($order as $index => $inputId) {
                ServiceInput::where('id', $inputId)->update(['order' => $index + 1]);
            }

            return response()->json(['success' => true, 'message' => 'Input order updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update input order']);
        }
    }

    public function formRequests(string $id) : View
    {
        $data['service'] = Service::findOrFail((int)$id);
        $data['serviceRequests'] = ServiceRequest::where('service_id', $id)->paginate(15);
        return view('admin.service.service.form.requests', $data);
    }
    public function formRequestsMail(string $id,Request $request) : string|JsonResponse{
        $rules = [
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }


        $be = BasicExtra::first();
        $from = $be->from_mail;

        $sub = $request->subject;
        $msg = $request->message;
        $to = $request->email;

        // Mail::to($to)->send(new ContactMail($from, $sub, $msg));

                // Send Mail
        $mail = new PHPMailer(true);

        if ($be->is_smtp == 1) {
            try {
                $mail->isSMTP();
                $mail->Host       = $be->smtp_host;
                $mail->SMTPAuth   = true;
                $mail->Username   = $be->smtp_username;
                $mail->Password   = $be->smtp_password;
                $mail->SMTPSecure = $be->encryption;
                $mail->Port       = $be->smtp_port;

                //Recipients
                $mail->setFrom($from);
                $mail->addAddress($to);

                // Content
                $mail->isHTML(true);
                $mail->Subject = $sub;
                $mail->Body    = $msg;

                $mail->send();
            } catch (Exception $e) {

            }
        } else {
            try {

                //Recipients
                $mail->setFrom($from);
                $mail->addAddress($to);

                // Content
                $mail->isHTML(true);
                $mail->Subject = $sub;
                $mail->Body    = $msg;

                $mail->send();
            } catch (Exception $e) {

            }
        }

        Session::flash('success', 'Mail sent successfully!');
        return "success";

    }
    public function formRequestsDelete(string $id,Request $request) : RedirectResponse{
        $serviceRequest = ServiceRequest::findOrFail((int)$request->service_request_id);
        $serviceRequest->delete();
        return back()->with("success", "Request deleted successfully!");
    }
    public function formRequestsStatus(string $id,Request $request) : RedirectResponse{
        $serviceRequest = ServiceRequest::findOrFail((int)$request->service_request_id);
        $serviceRequest->update([
            'status' => $request->status
        ]);
        return back()->with("success",'Request status updated successfully!');
    }
    public function formRequestsBulkDelete(string $id,Request $request) : RedirectResponse{
        $ids = $request->ids;
        foreach ($ids as $id) {
            $serviceRequest = ServiceRequest::findOrFail((int)$id);
            $serviceRequest->delete();
        }
        return back()->with("success", "Requests deleted successfully!");
    }
}
