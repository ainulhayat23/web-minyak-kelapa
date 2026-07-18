<footer class="border-t border-red-100 bg-white">

    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

            {{-- Identitas --}}
            <div class="flex items-center gap-3">

                <img
                    src="{{ asset('images/brand/logo-maloppo-wordmark.jpg') }}"
                    alt="Logo UMKM Maloppo"
                    class="h-10 w-auto rounded-lg object-contain"
                >

                <div>
                    <p class="text-sm font-bold text-red-700">
                        UMKM Maloppo
                    </p>

                    <p class="text-xs text-gray-500">
                        Produk minyak kelapa murni dari kelapa pilihan.
                    </p>
                </div>

            </div>

            {{-- Media Sosial --}}
            <div class="flex flex-col gap-2 sm:items-end">

                <p class="text-xs font-semibold text-gray-600">
                    Ikuti Maloppo
                </p>

                <x-social-media />

            </div>

        </div>

        <div class="mt-5 flex flex-col gap-2 border-t border-red-100 pt-4 text-xs text-gray-500 sm:flex-row sm:items-center sm:justify-between">

            <p>
                &copy; {{ date('Y') }} UMKM Maloppo.
            </p>

            <p class="font-medium text-red-700">
                Produk lokal dari kelapa pilihan.
            </p>

        </div>

    </div>

</footer>