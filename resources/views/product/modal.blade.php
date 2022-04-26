<div class="modal fade" id="store_or_update_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-1"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="store_or_update_form">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="update_id" id="update_id">
                        <div class="col-md-9">
                            <x-form.selectbox labelName="Subcategory" name="subcategory_id" required="required"
                                col="col-md-12 mb-3" class="selectpicker">
                                @if(!$data['subcategories']->isEmpty())
                                    @foreach ($data['subcategories'] as $subcategory)
                                        <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                    @endforeach
                                @endif
                            </x-form.selectbox>
                            <x-form.textbox labelName="Product title" name="title" required="required"
                                col="col-md-12 mb-3" placeholder="Enter product title" />
                            <div class="required">
                                <label for="price" class="form-lebel mb-2">Price</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">$</span>
                                    <input type="text" class="form-control" name="price" id="price" placeholder="Price"
                                        aria-label="Price" aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <x-form.textarea LabelName="Description" name="description" placeholder="Enter description" />

                        </div>
                        <div class="col-md-3">
                            <div class="form-group col-md-12">
                                <label for="image">Product Image</label>
                                <div class="col-md-12 px-0 text-center">
                                    <div id="image">

                                    </div>
                                </div>
                                <input type="hidden" name="old_image" id="old_image">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm" id="save-btn"></button>
                </div>
            </form>
        </div>
    </div>
</div>
