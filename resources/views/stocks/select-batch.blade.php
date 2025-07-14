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
                  placeholder="Cari batch... Nama Product... Tahun..."
               >
               <button class="btn" type="button" id="clearSearch">
                  <i class="bi bi-x-circle"></i>
               </button>
            </div>
         </div>
      </div>

      {{-- No Batches --}}
      <div id="noBatchesMessage" class="text-center text-muted fw-semibold mb-5" style="display: none;">
         Batch tidak ada.
      </div>
      {{-- Alert Success --}}
      <div class="container-fluid">
         @if (session('error'))
               <div id="success-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
                  <i class="bi bi-check-circle me-2"></i> {{ session('error') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>
         @endif
      </div>
            
      {{-- CATEGORY SECTIONS --}}
      @foreach($groupedBatches as $period => $batches)
         <div class="category-section px-4" data-category="{{ Str::slug($period) }}">
            <h4 class="category-heading">
               <i class="bi bi-calendar-range me-2"></i> {{ $period }}
            </h4>
            <div class="row g-2 category-row" data-category="{{ Str::slug($period) }}">
                @foreach($batches as $batch)
                    <div 
                        class="col-auto product-card-wrapper"
                        data-name="{{ strtolower(
                            $batch->batch_code . ' ' . 
                            $batch->product->name . ' ' .
                            ($batch->production_date ? \Carbon\Carbon::parse($batch->production_date)->format('d-m-Y') : '-') . ' ' .
                            ($batch->expired ? \Carbon\Carbon::parse($batch->expired)->format('d-m-Y') : '-')
                        ) }}"
                        data-category="{{ Str::slug($period) }}"
                    >
                        <form action="{{ route('movements.create') }}" method="GET">
                            <input type="hidden" name="batch_id" value="{{ $batch->id }}">
                            <button type="submit" class="product-card">
                                <div class="card h-100" style="width: 300px; height: 300px;">
                                    <div class="card-body d-flex justify-content-center align-items-center flex-column">
                                        <h5 class="card-title text-center mb-2">{{ $batch->batch_code }}</h5>
                                        <p class="text-muted mb-1">{{ $batch->product->name }}</p>
                                        <p class="mb-0 text-center">
                                            Prod: {{ $batch->production_date ? \Carbon\Carbon::parse($batch->production_date)->format('d-m-Y') : '-' }}<br>
                                            Exp: {{ $batch->expired ? \Carbon\Carbon::parse($batch->expired)->format('d-m-Y') : '-' }} <br>
                                            Stock: <strong class="text-primary">{{ $batch->stock }}</strong>
                                        </p>
                                    </div>
                                </div>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
         </div>
      @endforeach

   </div>
</x-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {
   const searchInput = document.getElementById('productSearch');
   const clearBtn = document.getElementById('clearSearch');
   const batchCards = document.querySelectorAll('.product-card-wrapper');
   const categorySections = document.querySelectorAll('.category-section');
   const noBatchesMessage = document.getElementById('noBatchesMessage');

   function filterBatches() {
      const searchTerm = searchInput.value.trim().toLowerCase();
      const foundCategories = new Set();
      let foundAnyBatch = false;

      batchCards.forEach(card => {
         const keywords = card.dataset.name || "";

         if (keywords.includes(searchTerm)) {
            card.style.display = '';
            foundCategories.add(card.dataset.category);
            foundAnyBatch = true;
         } else {
            card.style.display = 'none';
         }
      });

      categorySections.forEach(section => {
         const catSlug = section.dataset.category;
         section.style.display = foundCategories.has(catSlug) || searchTerm === '' ? '' : 'none';
      });

      noBatchesMessage.style.display = foundAnyBatch || searchTerm === '' ? 'none' : 'block';
   }

   searchInput.addEventListener('input', filterBatches);

   clearBtn.addEventListener('click', () => {
      searchInput.value = '';
      filterBatches();
   });
});
</script>

<script src="{{ asset('js/timerTimeout.js') }}"></script>