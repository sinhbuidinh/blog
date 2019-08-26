@if (!empty($target_id) && !empty($save_id) && !empty($title))
<button type="button" id="btn_show_{{ $target_id }}" class="full_width form-control" data-toggle="modal" data-target="#{{ $target_id }}" style="display: none;">{{ trans('label.agency') }}</button>
<div class="modal fade" id="{{ $target_id }}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="body_{{ $target_id }}">{{ $body ?? '' }}</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('label.close') }}</button>
                @if(!isset($hide_save_btn))
                <button class="btn btn-primary" id="{{ $save_id }}" type="submit">{{ trans('label.save') }}</button>
                @endif
            </div>
        </div>
    </div>
</div>
@endif