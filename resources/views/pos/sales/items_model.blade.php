<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Add New Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form class="addItemForm">
            {{ csrf_field() }}
            <input type="hidden" name="select_id" id="select_id" value="{{ $id }}">
            <div class="form-group">
                <label>Name <span class="required">*</span></label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category_id" class="form-control">
                    <option value="">Select Category</option>
                    @foreach ($category as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Color</label>
                <select name="color" class="form-control">
                    <option value="">Select Color</option>
                    @foreach ($color as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Size</label>
                <select name="size" class="form-control">
                    <option value="">Select Size</option>
                    @foreach ($size as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Sales Price <span class="required">*</span></label>
                <input type="number" name="sales_price" class="form-control" step="0.01" required>
            </div>
            <div class="form-group">
                <label>Unit</label>
                <input type="text" name="unit" class="form-control">
            </div>
            <div class="form-group">
                <label>Tax Rate</label>
                <select name="tax_rate" class="form-control">
                    <option value="0">No Tax</option>
                    <option value="0.16">Exclusive 16%</option>
                    <option value="0.18">Exclusive 18%</option>
                </select>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <button type="button" class="btn btn-primary" onclick="saveItem()">Save</button>
        </form>
    </div>
</div>
