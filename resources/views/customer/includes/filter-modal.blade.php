<!-- Modal -->
<div class="modal fade" id="filter-modal" tabindex="-1" aria-labelledby="filter-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="filter-modal-label">Filters</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-2 accordion" style="padding:0 30px 0 10px; width:100% " id="filters">
                    @foreach ($productSpecs as $specName => $values)
                        @php 
                            $index_1 = $loop->index;
                        @endphp
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelStayOpen-collapse-{{$index_1}}" aria-expanded="true"
                                    aria-controls="panelStayOpen-collapse-{{$index_1}}">
                                    {{ucfirst($specName)}}
                                </button>
                            </h2>
                            <div id="panelStayOpen-collapse-{{$index_1}}" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    @foreach($values as $key => $spec) 
                                        <div>
                                            <input type="checkbox" class="mx-2 form-check-input filter" name="{{$specName}}"
                                                id="{{$spec}}-{{$index_1}}-{{$loop->index}}" value="{{$spec}}">
                                            <label for="{{$spec}}-{{$index_1}}-{{$loop->index}}">{{$spec}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Remove all Filters</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Show results (<span
                        id="nr-products">{{$products->count()}}</span>)</button>
            </div>
        </div>
    </div>
</div>