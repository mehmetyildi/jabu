<div>
    {{$createButton}}
    <div wire:loading.delay>
        <div
            style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index: 9999; width: 100%; height: 100%; opacity: .75;">
            <div style="width: 100px; height: 100px; top: 50%; left: 50%;" class="spinner-border search-spinner"></div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12">
        <div class="row">
            {{$extra_criterias}}
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            {{$thead}}
            </thead>
            <tbody>
            {{$tbody}}
            @if(!count($records))
                <tr>
                    No records.
                </tr>
            @endif
            </tbody>
        </table>
    </div>
    Total {{ $records->total() }} records
    <div class="col-sm-12">
        {{$records->links('vendor.livewire.bootstrap')}}
    </div>
</div>

