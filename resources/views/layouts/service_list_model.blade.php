<div class="modal fade" id="services_list_model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('label.services_model') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped" style="width: 100%">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>{{ trans('label.service_name') }}</th>
                            <th>{{ trans('label.price') }}</th>
                            <th>{{ trans('label.note') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($services_display))
                        @php
                            //services explode to element
                            $old_services = stringify2array(old('services'));
                            $checked_services = array_pluck($old_services, 'key') ?: [];
                            $service_names = array_pluck($old_services, 'name') ?: [];
                            $service_names = implode(', ', $service_names);
                        @endphp
                        @foreach($services_display as $s)
                        @php
                            $tr_class = '';
                            $checkbox = '';
                            if(in_array($s['key'], $checked_services)) {
                                $tr_class = ' table-success';
                                $checkbox = 'checked="checked"';
                            }
                        @endphp
                        <tr class="service_id_choose{{ $tr_class }}">
                            <td>
                                <input type="checkbox" name="service_id[]"
                                {{ $checkbox }}
                                data-key="{{ $s['key'] }}"
                                @if(!empty($s['atleast']))
                                data-atleast="{{ $s['atleast'] }}"
                                @endif
                                @if(!empty($s['limit']))
                                data-limit="{{ $s['limit'] }}"
                                @endif
                                @if(!empty($s['price']))
                                data-price_range="{{ $s['price'] }}"
                                @endif
                                data-name="{{ $s['name'] }}"
                                data-math="{{ data_get($s, 'math', '+') }}"
                                value="{{ $s['key'] == 'package_in' ? $val_pack_in : $s['value'] }}">
                            </td>
                            <td>{{ $s['name'] }}</td>
                            <td>{{ $s['display'] }}</td>
                            <td>{!! $s['note'] !!}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="4">{{ trans('message.empty_service') }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('label.close') }}</button>
                <button class="btn btn-primary" id="add_services" type="submit">{{ trans('label.save') }}</button>
            </div>
        </div>
    </div>
</div>