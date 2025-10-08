@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">Requests</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{route('admin.dashboard')}}">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Request Management</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Requests</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card-title d-inline-block">Requests</div>
                </div>
                <div class="col-lg-6">
                    <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{route('admin.service.form.requests.bulk.delete', $service->id)}}"><i class="flaticon-interface-5"></i> Delete</button>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($serviceRequests) == 0)
                <h3 class="text-center">NO REQUEST FOUND</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">
                            <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Details</th>
                        <th scope="col">Status</th>
                        <th scope="col">Mail</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($serviceRequests as $key => $serviceRequest)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{$serviceRequest->id}}">
                          </td>
                          <td>{{convertUtf8($serviceRequest->fname)}}</td>
                          <td>{{convertUtf8($serviceRequest->email)}}</td>
                          <td>
                            <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#detailsModal{{$serviceRequest->id}}"><i class="fas fa-eye"></i> View</button>
                          </td>
                          <td>
                            <form id="statusForm{{$serviceRequest->id}}" class="d-inline-block" action="{{route('admin.service.form.requests.status', $service->id)}}" method="post">
                              @csrf
                              <input type="hidden" name="service_request_id" value="{{$serviceRequest->id}}">
                              <select class="form-control
                              @if ($serviceRequest->status == "Pending")
                                bg-warning
                              @elseif ($serviceRequest->status == "Processing")
                                bg-primary
                              @elseif ($serviceRequest->status == "Completed")
                                bg-success
                              @elseif ($serviceRequest->status == "Rejected")
                                bg-danger
                              @endif
                              " name="status" onchange="document.getElementById('statusForm{{$serviceRequest->id}}').submit();">
                                <option value="Pending" @selected($serviceRequest->status == "Pending")>Pending</option>
                                <option value="Processing" @selected($serviceRequest->status == "Processing")>Processing</option>
                                <option value="Completed" @selected($serviceRequest->status == "Completed")>Completed</option>
                                <option value="Rejected" @selected($serviceRequest->status == "Rejected")>Rejected</option>
                              </select>
                            </form>
                          </td>
                          <td>
                            <a href="#" class="btn btn-primary btn-sm editbtn" data-target="#mailModal" data-toggle="modal" data-email="{{$serviceRequest->email}}"><i class="far fa-envelope"></i> Send</a>
                          </td>
                          <td>
                            <form class="deleteform d-inline-block" action="{{route('admin.service.form.requests.delete', $service->id)}}" method="post">
                              @csrf
                              <input type="hidden" name="service_request_id" value="{{$serviceRequest->id}}">
                              <button type="submit" class="btn btn-danger btn-sm deletebtn">
                                <span class="btn-label">
                                  <i class="fas fa-trash"></i>
                                </span>
                                Delete
                              </button>
                            </form>
                          </td>
                        </tr>

                        @includeif('admin.service.service.form.request-details')
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @endif
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="d-inline-block mx-auto">
              {{$serviceRequests->links()}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Send Mail Modal -->
  <div class="modal fade" id="mailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Send Mail</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="ajaxEditForm" class="" action="{{route('admin.service.form.requests.mail', $service->id)}}" method="POST">
            @csrf
            <div class="form-group">
              <label for="">Client Mail **</label>
              <input id="inemail" type="text" class="form-control" name="email" value="" placeholder="Enter email">
              <p id="eerremail" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for="">Subject **</label>
              <input id="insubject" type="text" class="form-control" name="subject" value="" placeholder="Enter subject">
              <p id="eerrsubject" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for="">Message **</label>
              <textarea id="inmessage" class="form-control summernote" name="message" data-height="150" placeholder="Enter message"></textarea>
              <p id="eerrmessage" class="mb-0 text-danger em"></p>
            </div>
          </form>
        </div>
        <div class="modal-footer">    
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="updateBtn" type="button" class="btn btn-primary">Send Mail</button>
        </div>
      </div>
    </div>
  </div>
@endsection
