<x-datatable :records="$records">
    <x-slot name="createButton">
        <a class="btn btn-primary" href="{{route('tasks.create')}}">
            New Task
        </a>
    </x-slot>
    <x-slot name="extra_criterias">
        <div class="form-group col-md-3">
            <label class="col-form-label text-left" for="inputGroupSelect01">Timeframe</label>
            <div class="input-group">
                <select class="custom-select" style="height: 31px; border: 1px solid #ced4da; border-radius: 3px; display: inline-block; width: 100%;" wire:model="timeframe" id="inputGroupSelect01">
                    @foreach(\Jabu\Task\Domain\Enums\Timeframe::cases() as $timeframe)
                        <option value="{{$timeframe->value}}">{{$timeframe->getValue()}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </x-slot>
    <x-slot name="thead">
        <tr>
            <th>Name</th>
            <th>Date</th>
            <th>Period</th>
            <th>Action</th>
        </tr>
    </x-slot>
    <x-slot name="tbody">
        @foreach($records as $record)
            @php
                assert($record instanceof \Jabu\Task\TaskRecurrence\Domain\Models\TaskRecurrence)
            @endphp
            <tr>
                <td>{{ $record->task->name }}</td>
                <td>{{ $record->date }}</td>
                <td>{{ $record->task->period->getValue() }}</td>

                <td>
                    <button type="button" wire:click="delete({{$record->task->id}})" class="btn btn-danger btn-xs"><i
                            class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-datatable>
