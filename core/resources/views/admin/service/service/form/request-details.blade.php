<!-- Details Modal -->
<div class="modal fade" id="detailsModal{{$serviceRequest->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <strong style="text-transform: capitalize;">Name:</strong>
                </div>
                <div class="col-lg-8">{{convertUtf8($serviceRequest->fname)}}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-4">
                    <strong style="text-transform: capitalize;">Email:</strong>
                </div>
                <div class="col-lg-8">{{convertUtf8($serviceRequest->email)}}</div>
            </div>
            <hr>

          @php
            $fields = json_decode($serviceRequest->fields, true);
          @endphp

          @foreach ($fields as $key => $field)
          <div class="row">
            <div class="col-lg-4">
              <strong style="text-transform: capitalize;">{{str_replace("_"," ",$key)}}:</strong>
            </div>
            <div class="col-lg-8">
                @if (is_array($field) && array_key_exists('value', $field) && is_array($field['value']))
                    @php
                        $str = implode(", ", $field['value']);
                    @endphp
                    {{$str}}
                @else
                    @if(is_array($field))
                        @if (array_key_exists('type', $field) && $field['type'] == 5)
                            <a href="{{asset('assets/front/files/' . $field['value'])}}" class="btn btn-primary btn-sm" download="{{$key . ".zip"}}">Download</a>
                        @else
                            @if (array_key_exists('value', $field))
                                {{$field['value']}}
                            @endif
                        @endif
                    @endif
                @endif
            </div>
          </div>
          <hr>
          @endforeach

          <div class="row">
            <div class="col-lg-4">
              <strong>Status:</strong>
            </div>
            <div class="col-lg-8">
              @if ($serviceRequest->status == "Pending")
                <span class="badge badge-warning">Pending</span>
              @elseif ($serviceRequest->status == "Processing")
                <span class="badge badge-secondary">Processing</span>
              @elseif ($serviceRequest->status == "Completed")
                <span class="badge badge-success">Completed</span>
              @elseif ($serviceRequest->status == "Rejected")
                <span class="badge badge-danger">Rejected</span>
              @endif
            </div>
          </div>
          <hr>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
