@foreach ($inputs as $input)
    <div class="{{ $input->type == 4 || $input->type == 3 || $input->type == 10 ? 'col-lg-12' : 'col-lg-6' }}">
        <div class="form-element mb-4">
            @if ($input->type == 10)
                <h5 class="mb-4 font-weight-bold">{{ convertUtf8($input->label) }}</h5>
                <hr>
            @endif
            @if ($input->type == 1 || $input->type == 8 || $input->type == 9)
                <label for="text{{ $input->name }}">{{ convertUtf8($input->label) }} @if ($input->required == 1)
                        <span>**</span>
                    @endif
                </label>
                <input name="{{ $input->name }}" id="text{{ $input->name }}" @if ($input->type == 8) type="tel" @elseif ($input->type == 9) type="email" @else type="text" @endif
                    value="{{ old("$input->name") }}" placeholder="{{ convertUtf8($input->placeholder) }}">
            @endif
            @if ($input->type == 2)
                <label for="select{{ $input->name }}">{{ convertUtf8($input->label) }} @if ($input->required == 1)
                        <span>**</span>
                    @endif
                </label>
                <select name="{{ $input->name }}" id="select{{ $input->name }}">
                    <option value="" selected disabled>{{ convertUtf8($input->placeholder) }}</option>
                    @foreach ($input->input_options as $option)
                        <option value="{{ convertUtf8($option->name) }}"
                            {{ old("$input->name") == convertUtf8($option->name) ? 'selected' : '' }}>
                            {{ convertUtf8($option->name) }}</option>
                    @endforeach
                </select>
            @endif

            @if ($input->type == 3)
                <label for="checkbox{{ $input->name }}">{{ convertUtf8($input->label) }} @if ($input->required == 1)
                        <span>**</span>
                    @endif
                </label>
                @foreach ($input->input_options as $option)
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" id="customCheckboxInline{{ $option->id }}"
                            name="{{ $input->name }}[]" id="checkbox{{ $input->name }}" class="custom-control-input"
                            value="{{ convertUtf8($option->name) }}"
                            {{ is_array(old("$input->name")) && in_array(convertUtf8($option->name), old("$input->name")) ? 'checked' : '' }}>
                        <label class="custom-control-label"
                            for="customCheckboxInline{{ $option->id }}">{{ convertUtf8($option->name) }}</label>
                    </div>
                @endforeach
            @endif

            @if ($input->type == 4)
                <label for="textarea{{ $input->name }}">{{ convertUtf8($input->label) }} @if ($input->required == 1)
                        <span>**</span>
                    @endif
                </label>
                <textarea name="{{ $input->name }}" id="textarea{{ $input->name }}" cols="30" rows="10"
                    placeholder="{{ convertUtf8($input->placeholder) }}">{{ old("$input->name") }}</textarea>
            @endif

            @if ($input->type == 6)
                <label for="datepicker{{ $input->name }}">{{ convertUtf8($input->label) }} @if ($input->required == 1)
                        <span>**</span>
                    @endif
                </label>
                <input class="datepicker" name="{{ $input->name }}" id="datepicker{{ $input->name }}" type="text"
                    value="{{ old("$input->name") }}" placeholder="{{ convertUtf8($input->placeholder) }}"
                    autocomplete="off">
            @endif

            @if ($input->type == 7)
                <label for="timepicker{{ $input->name }}">{{ convertUtf8($input->label) }} @if ($input->required == 1)
                        <span>**</span>
                    @endif
                </label>
                <input class="timepicker" name="{{ $input->name }}" id="timepicker{{ $input->name }}" type="text"
                    value="{{ old("$input->name") }}" placeholder="{{ convertUtf8($input->placeholder) }}"
                    autocomplete="off">
            @endif

            @if ($input->type == 5)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-element mb-2">
                            <label for="file{{ $input->name }}">{{ $input->label }} @if ($input->required == 1)
                                    <span>**</span>
                                @endif
                            </label>
                            <input type="file" name="{{ $input->name }}" id="file{{ $input->name }}"
                                value="">
                        </div>
                        <p class="text-warning mb-0">** {{ __('Only zip file is allowed') }}</p>
                    </div>
                </div>
            @endif

            @if ($errors->has("$input->name"))
                <p class="text-danger mb-0">{{ $errors->first("$input->name") }}</p>
            @endif
        </div>
    </div>
@endforeach
