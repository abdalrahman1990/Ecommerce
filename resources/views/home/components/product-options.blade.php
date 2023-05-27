<div class="row">
    <div class="div col s12 m6 l4 offset-l4 xl4 offset-xl4 login-field">
        <form action="{{route('products')}}" id="sort-form">
            <input type="hidden" name="items_per_page" value="{{request()->items_per_page}}">
            <input type="hidden" name="category" value="{{request()->category}}">
            <div class="input-field">
                <select name="sort_by" id="sort-option">
                <option value="" disabled selected>Choose your option</option>
                <option value="latest" {{request()->sort_by == 'latest' ? 'selected' : '' }}>Latest</option>
                <option value="name" {{request()->sort_by == 'name' ? 'selected' : '' }}>Name</option>
                <option value="high-to-low" {{request()->sort_by == 'high-to-low' ? 'selected' : '' }}>Price | High to Low</option>
                <option value="low-to-high" {{request()->sort_by == 'low-to-high' ? 'selected' : '' }}>Price | Low to High</option>
                </select>
                <label>Sort by:</label>
            </div>
        </form>
    </div>
    <div class="div col s12 m6 l4 xl4 login-field">
        <form action="{{route('products')}}" id="items-form">
            <input type="hidden" name="sort_by" value="{{request()->sort_by}}">
            <input type="hidden" name="category" value="{{request()->category}}">
            <div class="input-field">
                <select name="items_per_page" id="items-option">
                <option value="" disabled selected>Choose your option</option>
                <option value="10" {{request()->items_per_page == '10' ? 'selected' : '' }}>10 Products</option>
                <option value="15" {{request()->items_per_page == '15' ? 'selected' : '' }}>15 Products</option>
                <option value="25" {{request()->items_per_page == '25' ? 'selected' : '' }}>25 Products</option>
                </select>
                <label>Items per page:</label>
            </div>
        </form>
    </div>
</div>