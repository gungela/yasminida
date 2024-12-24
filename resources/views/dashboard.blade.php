<x-app-layout>
    @section('title', 'Dashboard')
    @section('page-title')
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">
                Dashboard
            </h1>
        </div>
    @endsection
    @section('content')
        <div class="container mt-3">
            <div class="row d-flex justify-content-evenly">
                <div class="col-xl-3 mb-1">
                    <div class="card bg-body hoverable card-xl-stretch mb-xl-8">
                        <div class="card-header align-content-center pt-5">
                            <h3 class="c    ard-title text-gray-800">Produk Masuk</h3>

                        </div>
                        <div class="card-body pt-5">
                            <div class="d-flex flex-stack">
                                <div class="d-flex align-items-senter">
                                    <span class="text-gray-900 fw-bolder fs-6">{{ $masuk }}<span>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xl-3 mb-1">

                    <div class="card bg-body hoverable card-xl-stretch mb-xl-8">
                        <div class="card-header align-content-center pt-5">

                            <h3 class="card-title text-gray-800">Produk Keluar</h3>

                        </div>
                        <div class="card-body pt-5">
                            <div class="d-flex flex-stack">

                                <div class="d-flex align-items-senter">
                                    <span class="text-gray-900 fw-bolder fs-6">{{ $keluar }}<span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xl-3 mb-1">

                    <div class="card bg-body hoverable card-xl-stretch mb-xl-8">
                        <div class="card-header align-content-center pt-5">

                            <h3 class="card-title text-gray-800">Produk Rusak</h3>

                        </div>
                        <div class="card-body pt-5">
                            <div class="d-flex flex-stack">

                                <div class="d-flex align-items-senter">
                                    <span class="text-gray-900 fw-bolder fs-6">{{ $rusak }}<span>
                                </div>
                            </div>
                        </div>
                    </div>
                
                </div>
                <div class="col-xl-3 mb-1"> <!-- Card Produk Tersedia -->
                    
                <div class="card bg-body hoverable card-xl-stretch mb-xl-8">
                     <div class="card-header align-content-center pt-5">
          
                           <h3 class="card-title text-gray-800">Produk Tersedia</h3>
                        
                        </div>
                        <div class="card-body pt-5">
                          <div class="d-flex flex-stack">
                    
                            <div class="d-flex align-items-senter">
                                    <span class="text-gray-900 fw-bolder fs-6">{{ $tersedia }}</span>
                                </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>
