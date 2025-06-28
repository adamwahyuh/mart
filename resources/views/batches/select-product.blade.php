<link rel="stylesheet" href="{{ asset('css/batches/select.css') }}">

<x-layout>
   <div class="page-wrapper">

      {{-- Search --}}
      <div class="d-flex justify-content-center mb-4">
         <div class="search-container">
            <div class="input-group search-bar">
               <input 
                  type="text" 
                  id="productSearch" 
                  class="form-control"
                  placeholder="Cari produk..."
               >
               <button class="btn" type="button" id="clearSearch">
                  <i class="bi bi-x-circle"></i>
               </button>
            </div>
         </div>
      </div>

      {{-- No Prodk --}}
      <div id="noProductsMessage" class="text-center text-muted fw-semibold mb-5" style="display: none;">
         Product tidak ada.
      </div>

      {{-- CATEGORY SECTIONS --}}
      @foreach($categories as $category)
         @if($category->products->count())
            <div class="category-section px-4" data-category="{{ Str::slug($category->name) }}">
               <h4 class="category-heading">
                  <i class="bi bi-tags-fill me-2"></i> {{ $category->name }}
               </h4>
               <div class="row g-2 category-row" data-category="{{ Str::slug($category->name) }}">
                    @foreach($category->products as $product)
                        <div 
                           class="col-auto product-card-wrapper"
                           data-name="{{ strtolower($product->name) }} {{ strtolower($category->name) }}"
                           data-category="{{ Str::slug($category->name) }}"
                        >
                            <form action="{{ route('batches.create') }}" method="GET">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="product-card">
                                    <div class="card h-100" style="width: 300px; height: 300px;">
                                        <div class="card-img-top-wrapper">
                                            @if($product->photo)
                                                <img src="{{ asset('storage/'.$product->photo) }}" alt="{{ $product->name }}" class="card-img-top img-fluid">
                                            @else
                                                <img src="{{ asset('img/default.png') }}" alt="Default Image" class="card-img-top img-fluid">
                                            @endif
                                        </div>
                                        <div class="card-body d-flex justify-content-center align-items-center">
                                            <h5 class="card-title text-center">{{ $product->name }}</h5>
                                        </div>
                                    </div>
                                </button>
                            </form>
                        </div>
                    @endforeach
               </div>
            </div>
         @endif
      @endforeach

   </div>
</x-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {
   const searchInput = document.getElementById('productSearch');
   const clearBtn = document.getElementById('clearSearch');
   const productCards = document.querySelectorAll('.product-card-wrapper');
   const categorySections = document.querySelectorAll('.category-section');
   const noProductsMessage = document.getElementById('noProductsMessage');

   function filterProducts() {
      const searchTerm = searchInput.value.trim().toLowerCase();
      const foundCategories = new Set();
      let foundAnyProduct = false;

      productCards.forEach(card => {
         const keywords = card.dataset.name || "";

         if (keywords.includes(searchTerm)) {
            card.style.display = '';
            foundCategories.add(card.dataset.category);
            foundAnyProduct = true;
         } else {
            card.style.display = 'none';
         }
      });

      categorySections.forEach(section => {
         const catSlug = section.dataset.category;
         section.style.display = foundCategories.has(catSlug) || searchTerm === '' ? '' : 'none';
      });

      noProductsMessage.style.display = foundAnyProduct || searchTerm === '' ? 'none' : 'block';
   }

   searchInput.addEventListener('input', filterProducts);

   clearBtn.addEventListener('click', () => {
      searchInput.value = '';
      filterProducts();
   });
});
</script>
