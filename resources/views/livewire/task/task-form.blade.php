<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card" style="margin-bottom: 10px">
            <div class="card-body">
                <div class="row">
                    {{$errors}}
                    <div class="form-group col-12 {{($errors->first('name')?'has-error':'')}}">
                        <label for="name-select" class="col-form-label text-left">Name *</label>
                        <div class="input-group">
                            {!! Form::text('name', null, ['class' => 'form-control'.($errors->first('name')?' form-control-danger':''), 'required' => 'required', 'wire:model'=>'name']) !!}
                        </div>
                        @if($errors->first('name'))
                            <div class="form-control-feedback text-danger mt-2">{{$errors->first('name')}}</div>
                        @endif
                    </div>
                    <div class="form-group col-12 {{($errors->first('description')?'has-error':'')}}">
                        <label for="description-select" class="col-form-label text-left">Description *</label>
                        <div class="input-group">
                            {!! Form::textarea('description', null, ['class' => 'form-control'.($errors->first('description')?' form-control-danger':''), 'required' => 'required', 'wire:model'=>'description']) !!}
                        </div>
                        @if($errors->first('description'))
                            <div class="form-control-feedback text-danger mt-2">{{$errors->first('description')}}</div>
                        @endif
                    </div>
                    <div class="form-group col-12 {{($errors->first('period')?'has-error':'')}}">
                        <label for="period-select" class="col-form-label text-left">Period *</label>
                        <select class="custom-select"
                                style="height: 38px; border: 1px solid #ced4da; border-radius: 6px; display: inline-block; width: 100%;"
                                wire:model="period" id="period-select">
                            <option value="0" selected>Choose...</option>
                            @foreach(\Jabu\Task\Domain\Enums\Period::cases() as $s)
                                <option value="{{$s->value}}">{{$s->getValue()}}</option>
                            @endforeach
                        </select>
                        @if($errors->first('period'))
                            <div class="form-control-feedback text-danger mt-2">{{$errors->first('period')}}</div>
                        @endif
                    </div>
                    @if($period === \Jabu\Task\Domain\Enums\Period::WEEKLY->value)
                        <script>
                            $(document).ready(function () {
                                $('.form-check-input').change(function () {
                                    let $element = $(this);
                                    $element.attr('checked', !$element.attr('checked'));
                                    let $elements = $('.form-check-input');
                                    let $selectedDays = [];
                                    $elements.each(function (index, elem) {
                                        if ($(this).attr('checked')) {
                                            $selectedDays.push(index + 1)
                                        }
                                    });
                                    $('#days').val($selectedDays)
                                    $('#days').trigger('change')
                                });
                                $('#days').change(function() {
                                    @this.days = $('#days').val()
                                })
                            })
                        </script>
                        <input hidden id="days" value="0" wire:model="days">
                        @foreach(\Jabu\Task\Domain\Enums\Days::cases() as $day)
                            <div class="form-check">
                                <input class="form-check-input" {{$days && \Illuminate\Support\Str::contains($days, $loop->index +1) ? 'checked' : ''}} type="checkbox" value="{{$loop->index +1}}"
                                       id="flexCheckDefault{{$loop->index}}">
                                <label class="form-check-label" for="flexCheckDefault{{$loop->index}}">
                                    {{$day->name}}
                                </label>
                            </div>
                        @endforeach
                    @endif
                    <div class="form-group col-6 {{($errors->first('recurrenceType')?'has-error':'')}}">
                        <label for="recurrenceType-select" class="col-form-label text-left">Recurrence Type *</label>
                        <select class="custom-select"
                                style="height: 38px; border: 1px solid #ced4da; border-radius: 6px; display: inline-block; width: 100%;"
                                wire:model="recurrenceType" id="recurrenceType-select">
                            <option value="0" selected>Choose...</option>
                            @foreach(\Jabu\Task\Domain\Enums\RecurrenceType::cases() as $s)
                                <option value="{{$s->value}}">{{$s->getValue()}}</option>
                            @endforeach
                        </select>
                        @if($errors->first('recurrenceType'))
                            <div class="form-control-feedback text-danger mt-2">{{$errors->first('recurrenceType')}}</div>
                        @endif
                    </div>
                    @if($recurrenceType === \Jabu\Task\Domain\Enums\RecurrenceType::NUMBER_OF_TIMES->value)
                        <div class="form-group col-6 {{($errors->first('numberOfTimes')?'has-error':'')}}">
                            <label for="numberOfTimes-select" class="col-form-label text-left">Name *</label>
                            <div class="input-group">
                                {!! Form::number('numberOfTimes', null, ['class' => 'form-control'.($errors->first('numberOfTimes')?' form-control-danger':''), 'required' => 'required', 'step' => 1, 'wire:model'=>'numberOfTimes']) !!}
                            </div>
                            @if($errors->first('numberOfTimes'))
                                <div class="form-control-feedback text-danger mt-2">{{$errors->first('numberOfTimes')}}</div>
                            @endif
                        </div>
                    @else
                        <div class="form-group col-3 {{($errors->first('startDate')?'has-error':'')}}">
                            <label for="startDate-select" class="col-form-label text-left">Start Date *</label>
                            <div class="input-group">
                                {!! Form::date('startDate', null, ['class' => 'form-control'.($errors->first('startDate')?' form-control-danger':''), 'required' => 'required', 'wire:model'=>'startDate']) !!}
                            </div>
                            @if($errors->first('startDate'))
                                <div class="form-control-feedback text-danger mt-2">{{$errors->first('startDate')}}</div>
                            @endif
                        </div>
                        <div class="form-group col-3 {{($errors->first('endDate')?'has-error':'')}}">
                            <label for="endDate-select" class="col-form-label text-left">End Date *</label>
                            <div class="input-group">
                                {!! Form::date('endDate', null, ['class' => 'form-control'.($errors->first('endDate')?' form-control-danger':''), 'required' => 'required', 'wire:model'=>'endDate']) !!}
                            </div>
                            @if($errors->first('endDate'))
                                <div class="form-control-feedback text-danger mt-2">{{$errors->first('endDate')}}</div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 offset-10">
                <button type="button" wire:click="submit" class="btn btn-success btn-block btn-lg"><i
                        class="fa fa-save"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>
