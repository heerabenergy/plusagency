<div class="row" id="app">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                @if (count($inputs) > 0)

                    @foreach ($inputs as $key => $input)
                        {{-- input type text --}}
                        @if ($input->type == 1 || $input->type == 8 || $input->type == 9)
                            <form action="{{ route($deleteRoute, $input->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <div class="form-group">
                                    <label for="">{{ $input->label }} @if ($input->required == 1)
                                            <span>**</span>
                                        @elseif($input->required == 0)
                                            (Optional)
                                        @endif
                                    </label>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" name="" value=""
                                                placeholder="{{ $input->placeholder }}">
                                        </div>
                                        <div class="col-md-1">
                                            <a class="btn btn-warning btn-md"
                                                href="{{ route($editRoute, $input->id) }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-1">
                                            <button @class([
                                                'btn-md btn',
                                                'btn-danger' => $input->active == 0,
                                                'btn-success' => $input->active == 1,
                                            ]) type="submit">
                                                <i @class([
                                                    'fa fa-toggle-on' => $input->active == 1,
                                                    'fa fa-toggle-off' => $input->active == 0,
                                                ])></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @elseif ($input->type == 10)
                            <form action="{{ route($deleteRoute, $input->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <div class="form-group">
                                    <label for="">{{ $input->label }}</label>
                                </div>
                                <div class="row">
                                    <div class="col-md-10">
                                        <input class="form-control disabled" disabled type="text" name="" value="You can edit or delete section with button"
                                            placeholder="{{ $input->placeholder }}">
                                    </div>
                                    <div class="col-md-1">
                                        <a class="btn btn-warning btn-md"
                                            href="{{ route($editRoute, $input->id) }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-1">
                                        <button @class([
                                            'btn-md btn',
                                            'btn-danger' => $input->active == 0,
                                            'btn-success' => $input->active == 1,
                                        ]) type="submit">
                                            <i @class([
                                                'fa fa-toggle-on' => $input->active == 1,
                                                'fa fa-toggle-off' => $input->active == 0,
                                            ])></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @elseif ($input->type == 2)
                            <form action="{{ route($deleteRoute, $input->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <div class="form-group">
                                    <label for="">{{ $input->label }} @if ($input->required == 1)
                                            <span>**</span>
                                        @elseif($input->required == 0)
                                            (Optional)
                                        @endif
                                    </label>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <select class="form-control" name="">
                                                <option value="" selected disabled>{{ $input->placeholder }}
                                                </option>
                                                @foreach ($input->input_options as $key => $option)
                                                    <option value="">{{ $option->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-1">
                                            <a class="btn btn-warning btn-md"
                                                href="{{ route($editRoute, $input->id) . '?language=' . request()->input('language') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-1">
                                            <button @class([
                                                'btn-md btn',
                                                'btn-danger' => $input->active == 0,
                                                'btn-success' => $input->active == 1,
                                            ]) type="submit">
                                                <i @class([
                                                    'fa fa-toggle-on' => $input->active == 1,
                                                    'fa fa-toggle-off' => $input->active == 0,
                                                ])></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @elseif ($input->type == 3)
                            <form action="{{ route($deleteRoute, $input->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <div class="form-group">
                                    <label for="">{{ $input->label }} @if ($input->required == 1)
                                            <span>**</span>
                                        @elseif($input->required == 0)
                                            (Optional)
                                        @endif
                                    </label>
                                    <div class="row">
                                        <div class="col-md-10">
                                            @foreach ($input->input_options as $key => $option)
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="customRadio{{ $option->id }}"
                                                        name="customRadio" class="custom-control-input">
                                                    <label class="custom-control-label"
                                                        for="customRadio{{ $option->id }}">{{ $option->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-md-1">
                                            <a class="btn btn-warning btn-md"
                                                href="{{ route($editRoute, $input->id) . '?language=' . request()->input('language') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-1">
                                            <button @class([
                                                'btn-md btn',
                                                'btn-danger' => $input->active == 0,
                                                'btn-success' => $input->active == 1,
                                            ]) type="submit">
                                                <i @class([
                                                    'fa fa-times' => $input->active == 1,
                                                    'fa fa-check' => $input->active == 0,
                                                ])></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @elseif ($input->type == 4)
                            <form action="{{ route($deleteRoute, $input->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <div class="form-group">
                                    <label for="">{{ $input->label }} @if ($input->required == 1)
                                            <span>**</span>
                                        @elseif($input->required == 0)
                                            (Optional)
                                        @endif
                                    </label>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <textarea class="form-control" name="" rows="5" cols="80" placeholder="{{ $input->placeholder }}"></textarea>
                                        </div>
                                        <div class="col-md-1">
                                            <a class="btn btn-warning btn-md"
                                                href="{{ route($editRoute, $input->id) . '?language=' . request()->input('language') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-1">
                                            <button @class([
                                                'btn-md btn',
                                                'btn-danger' => $input->active == 1,
                                                'btn-success' => $input->active == 0,
                                            ]) type="submit">
                                                <i @class([
                                                    'fa fa-toggle-on' => $input->active == 1,
                                                    'fa fa-toggle-off' => $input->active == 0,
                                                ])></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @elseif ($input->type == 6)
                            <form action="{{ route($deleteRoute, $input->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <div class="form-group">
                                    <label for="">{{ $input->label }} @if ($input->required == 1)
                                            <span>**</span>
                                        @elseif($input->required == 0)
                                            (Optional)
                                        @endif
                                    </label>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <input type="text" class="form-control datepicker" autocomplete="off"
                                                placeholder="{{ $input->placeholder }}">
                                        </div>
                                        <div class="col-md-1">
                                            <a class="btn btn-warning btn-md"
                                                href="{{ route($editRoute, $input->id) . '?language=' . request()->input('language') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-1">
                                            <button @class([
                                                'btn-md btn',
                                                'btn-danger' => $input->active == 0,
                                                'btn-success' => $input->active == 1,
                                            ]) type="submit">
                                                <i @class([
                                                    'fa fa-times' => $input->active == 1,
                                                    'fa fa-check' => $input->active == 0,
                                                ])></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @elseif ($input->type == 7)
                            <form action="{{ route($deleteRoute, $input->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <div class="form-group">
                                    <label for="">{{ $input->label }} @if ($input->required == 1)
                                            <span>**</span>
                                        @elseif($input->required == 0)
                                            (Optional)
                                        @endif
                                    </label>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <input type="text" class="form-control timepicker" autocomplete="off"
                                                placeholder="{{ $input->placeholder }}">
                                        </div>
                                        <div class="col-md-1">
                                            <a class="btn btn-warning btn-md"
                                                href="{{ route($editRoute, $input->id) . '?language=' . request()->input('language') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-1">
                                            <button @class([
                                                'btn-md btn',
                                                'btn-danger' => $input->active == 0,
                                                'btn-success' => $input->active == 1,
                                            ]) type="submit">
                                                <i @class([
                                                    'fa fa-toggle-on' => $input->active == 1,
                                                    'fa fa-toggle-off' => $input->active == 0,
                                                ])></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @elseif ($input->type == 5)
                            <form action="{{ route($deleteRoute, $input->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <div class="form-group">
                                    <label for="">{{ $input->label }} @if ($input->required == 1)
                                            <span>**</span>
                                        @elseif($input->required == 0)
                                            (Optional)
                                        @endif
                                    </label>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <input type="file">
                                        </div>
                                        <div class="col-md-1">
                                            <a class="btn btn-warning btn-md"
                                                href="{{ route($editRoute, $input->id) . '?language=' . request()->input('language') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-1">
                                            <button @class([
                                                'btn-md btn',
                                                'btn-danger' => $input->active == 0,
                                                'btn-success' => $input->active == 1,
                                            ]) type="submit">
                                                <i @class([
                                                    'fa fa-toggle-on' => $input->active == 1,
                                                    'fa fa-toggle-off' => $input->active == 0,
                                                ])></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
                    @endforeach

                @endif

                {{-- <div class="form-group">
                <label for="">NDA file @if ($ndaIn->required == 1) <span>**</span> @elseif($ndaIn->required == 0) (Optional) @endif</label>
                <div class="row">
                    <div class="col-md-10">
                        <input type="file">
                    </div>
                    <div class="col-md-1">
                    <a class="btn btn-warning btn-md" href="{{route('admin.quote.inputEdit', 1) . '?language=' . request()->input('language')}}">
                        <i class="fas fa-edit"></i>
                    </a>
                    </div>
                </div>
            </div> --}}
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Create Input</div>
            </div>

            <form id="ajaxForm" action="{{ $createRoute }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for=""><strong>Field Type</strong></label>
                    <div class="">
                        <div class="form-check form-check-inline">
                            <input name="type" class="form-check-input" type="radio" id="inlineRadio1"
                                value="1" v-model="type" @change="typeChange()">
                            <label class="form-check-label" for="inlineRadio1">Text Field</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="type" class="form-check-input" type="radio" id="inlineRadio1"
                                value="10" v-model="type" @change="typeChange()">
                            <label class="form-check-label" for="inlineRadio1">Section Field</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="type" class="form-check-input" type="radio" id="inlineRadio1"
                                value="8" v-model="type" @change="typeChange()">
                            <label class="form-check-label" for="inlineRadio1">Mobile Field</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="type" class="form-check-input" type="radio" id="inlineRadio1"
                                value="9" v-model="type" @change="typeChange()">
                            <label class="form-check-label" for="inlineRadio1">Email Field</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="type" class="form-check-input" type="radio" id="inlineRadio2"
                                value="2" v-model="type" @change="typeChange()">
                            <label class="form-check-label" for="inlineRadio2">Select</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="type" class="form-check-input" type="radio" id="inlineRadio3"
                                value="3" v-model="type" @change="typeChange()">
                            <label class="form-check-label" for="inlineRadio3">Checkbox</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="type" class="form-check-input" type="radio" id="inlineRadio4"
                                value="4" v-model="type" @change="typeChange()">
                            <label class="form-check-label" for="inlineRadio4">Textarea</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="type" class="form-check-input" type="radio" id="inlineRadio6"
                                value="6" v-model="type" @change="typeChange()">
                            <label class="form-check-label" for="inlineRadio6">Datepicker</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="type" class="form-check-input" type="radio" id="inlineRadio7"
                                value="7" v-model="type" @change="typeChange()">
                            <label class="form-check-label" for="inlineRadio7">Timepicker</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="type" class="form-check-input" type="radio" id="inlineRadio5"
                                value="5" v-model="type" @change="typeChange()">
                            <label class="form-check-label" for="inlineRadio5">File</label>
                        </div>
                    </div>
                    <p id="errtype" class="mb-0 text-danger em"></p>
                </div>

                <div v-if="isRequiredShow" class="form-group">
                    <label>Required</label>
                    <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="required" value="1" class="selectgroup-input" checked>
                            <span class="selectgroup-button">Yes</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="required" value="0" class="selectgroup-input">
                            <span class="selectgroup-button">No</span>
                        </label>
                    </div>
                    <p id="errrequired" class="mb-0 text-danger em"></p>
                </div>
                <div class="form-group">
                    <label for=""><strong>Unique Name</strong></label>
                    <div class="">
                        <input type="text" class="form-control" name="unique_name" value=""
                            placeholder="Enter Unique Name">
                    </div>
                    <p id="errunique_name" class="mb-0 text-danger em"></p>
                </div>
                <div class="form-group">
                    <label for=""><strong>Label Name</strong></label>
                    <div class="">
                        <input type="text" class="form-control" name="label" value=""
                            placeholder="Enter Label Name">
                    </div>
                    <p id="errlabel" class="mb-0 text-danger em"></p>
                </div>

                <div class="form-group" v-if="placeholdershow">
                    <label for=""><strong>Placeholder</strong></label>
                    <div class="">
                        <input type="text" class="form-control" name="placeholder" value=""
                            placeholder="Enter Placeholder">
                    </div>
                    <p id="errplaceholder" class="mb-0 text-danger em"></p>
                </div>


                <div class="form-group" v-if="counter > 0" id="optionarea">
                    <label for=""><strong>Options</strong></label>
                    <div class="row mb-2 counterrow" v-for="n in counter" :id="'counterrow' + n">
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="options[]" value=""
                                placeholder="Option label">
                        </div>

                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-md text-white btn-sm"
                                @click="removeOption(n)"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <p id="erroptions.0" class="mb-2 text-danger em"></p>
                    <button type="button" class="btn btn-success btn-sm text-white" @click="addOption()"><i
                            class="fa fa-plus"></i> Add Option</button>
                </div>

                <div class="form-group text-center">
                    <button id="submitBtn" type="submit" class="btn btn-primary btn-sm">ADD FIELD</button>
                </div>
            </form>

        </div>

    </div>
</div>


@section('vuescripts')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                type: 1,
                counter: 0,
                placeholdershow: true,
                isRequiredShow: true
            },
            methods: {
                typeChange() {
                    if (this.type == 3 || this.type == 5 || this.type == 10) {
                        this.placeholdershow = false;
                    } else {
                        this.placeholdershow = true;
                    }
                    if (this.type == 10) {
                        this.isRequiredShow = false;
                    } else {
                        this.isRequiredShow = true;
                    }
                    if (this.type == 2 || this.type == 3) {
                        this.counter = 1;
                    } else {
                        this.counter = 0;
                    }
                },
                addOption() {
                    $("#optionarea").addClass('d-block');
                    this.counter++;
                },
                removeOption(n) {
                    $("#counterrow" + n).remove();
                    if ($(".counterrow").length == 0) {
                        this.counter = 0;
                    }
                }
            }
        })
    </script>
@endsection
