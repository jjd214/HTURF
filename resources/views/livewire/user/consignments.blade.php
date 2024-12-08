<div>
    <div class="card-box mb-20 pd-10">
        <div class="row">
            <!-- Search and Filter -->
            <div class="col-md-3 mb-10">
                <div class="input-group custom">
                    <div class="input-group-prepend custom">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                    <input type="text" class="form-control" wire:model.live.debounce.300ms="search"
                        placeholder="Search product name">
                </div>
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-3 mb-10">
                <select class="custom-select form-control" wire:model.live="visibility">
                    <option value="">All</option>
                    <option value="public">Public</option>
                    <option value="private">Private</option>
                </select>
            </div>
        </div>

        <!-- Responsive Table -->
        <div class="table-responsive">
            <table class="table table-hover stripe styled-table" style="width: 100%;" wire:poll.keep-alive>
                <thead>
                    <tr>
                        <th><b>Item</b></th>
                        <th><b>Sku</b></th>
                        <th><b>Name</b></th>
                        <th><b>Size</b></th>
                        <th><b>Quantity</b></th>
                        <th><b>Status</b></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Example Item</td>
                        <td>123456</td>
                        <td>Product Name</td>
                        <td>Medium</td>
                        <td>10</td>
                        <td>Available</td>
                    </tr>
                    <tr>
                        <td>Example Item</td>
                        <td>123456</td>
                        <td>Product Name</td>
                        <td>Medium</td>
                        <td>10</td>
                        <td>Available</td>
                    </tr>
                    <tr>
                        <td>Example Item</td>
                        <td>123456</td>
                        <td>Product Name</td>
                        <td>Medium</td>
                        <td>10</td>
                        <td>Available</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination and Per Page Control -->
        <div class="row mt-20">
            <div class="col-md-3">
                <select class="custom-select form-control" wire:model.live="per_page">
                    <option value="">Select Per Page</option>
                    <option value="1">1</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
            </div>
            <div class="col-md-9 text-right">

            </div>
        </div>
    </div>
</div>
