<!-- Product Comments Section -->
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-8">Komentar & Rating Produk</h2>

    <!-- Comment Form -->
    <div class="mb-8 pb-8 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Berikan Komentar & Rating Anda</h3>
        
        <form id="commentForm" class="space-y-4">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <!-- Star Rating -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Rating Produk</label>
                <div class="flex gap-2" id="ratingStars">
                    @for ($i = 1; $i <= 5; $i++)
                        <button 
                            type="button" 
                            class="star-btn text-4xl transition" 
                            data-rating="{{ $i }}"
                            title="{{ $i }} bintang"
                        >
                            ☆
                        </button>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating" value="">
                <small class="text-gray-500 mt-1" id="ratingLabel">Pilih rating (1-5 bintang)</small>
            </div>

            <!-- Visitor Name -->
            <div>
                <label for="visitor_name" class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Anda <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="visitor_name" 
                    name="visitor_name" 
                    required
                    placeholder="Masukkan nama Anda" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Visitor Phone -->
            <div>
                <label for="visitor_phone" class="block text-sm font-medium text-gray-700 mb-1">
                    Nomor Telepon <span class="text-red-500">*</span>
                </label>
                <input 
                    type="tel" 
                    id="visitor_phone" 
                    name="visitor_phone" 
                    required
                    placeholder="Masukkan nomor telepon Anda" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Visitor Email -->
            <div>
                <label for="visitor_email" class="block text-sm font-medium text-gray-700 mb-1">
                    Email <span class="text-red-500">*</span>
                </label>
                <input 
                    type="email" 
                    id="visitor_email" 
                    name="visitor_email" 
                    required
                    placeholder="Masukkan email Anda" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <small class="text-gray-500">Email akan digunakan untuk mengirimkan notifikasi terima kasih</small>
            </div>

            <!-- Comment Text -->
            <div>
                <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">
                    Komentar (Opsional)
                </label>
                <textarea 
                    id="comment" 
                    name="comment" 
                    rows="4"
                    placeholder="Bagikan pengalaman Anda dengan produk ini..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                ></textarea>
                <small class="text-gray-500">Maksimal 1000 karakter</small>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-semibold hover:bg-blue-500 transition"
                id="submitBtn"
            >
                Kirim Komentar & Rating
            </button>
        </form>
    </div>

    <!-- Success Message -->
    <div id="successMessage" class="hidden mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        <p class="font-semibold">✓ Terima kasih atas komentar Anda!</p>
        <p class="text-sm">Email konfirmasi telah dikirim. Tim kami akan memeriksa komentar Anda.</p>
    </div>

    <!-- Error Message -->
    <div id="errorMessage" class="hidden mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
        <p class="font-semibold">⚠ Terjadi kesalahan</p>
        <p class="text-sm" id="errorText"></p>
    </div>

    <!-- Existing Comments -->
    @if ($product->comments()->where('is_approved', true)->exists())
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Komentar dari Pembeli Lainnya</h3>
            <div class="space-y-4">
                @foreach ($product->comments()->where('is_approved', true)->latest()->get() as $comment)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-start justify-between mb-2">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $comment->visitor_name }}</p>
                                <div class="flex gap-1 text-yellow-400 text-sm">
                                    @for ($i = 0; $i < $comment->rating; $i++)
                                        ★
                                    @endfor
                                    @for ($i = $comment->rating; $i < 5; $i++)
                                        ☆
                                    @endfor
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">{{ $comment->created_at->format('d M Y') }}</span>
                        </div>
                        @if ($comment->comment)
                            <p class="text-gray-700">{{ $comment->comment }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-8">
            <p class="text-gray-500">Belum ada komentar untuk produk ini. Jadilah yang pertama!</p>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('commentForm');
    const stars = document.querySelectorAll('.star-btn');
    const ratingInput = document.getElementById('rating');
    const ratingLabel = document.getElementById('ratingLabel');
    const submitBtn = document.getElementById('submitBtn');
    const successMsg = document.getElementById('successMessage');
    const errorMsg = document.getElementById('errorMessage');
    const errorText = document.getElementById('errorText');

    // Star rating handler
    stars.forEach(star => {
        star.addEventListener('click', function(e) {
            e.preventDefault();
            const rating = this.dataset.rating;
            ratingInput.value = rating;
            ratingLabel.textContent = `${rating} bintang dipilih`;

            stars.forEach((s, index) => {
                s.textContent = index < rating ? '★' : '☆';
                s.classList.toggle('text-yellow-400', index < rating);
            });
        });

        star.addEventListener('mouseover', function(e) {
            const rating = this.dataset.rating;
            stars.forEach((s, index) => {
                s.textContent = index < rating ? '★' : '☆';
            });
        });
    });

    // Reset stars on mouse out
    document.getElementById('ratingStars').addEventListener('mouseout', function() {
        const currentRating = ratingInput.value || 0;
        stars.forEach((s, index) => {
            s.textContent = index < currentRating ? '★' : '☆';
        });
    });

    // Form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!ratingInput.value) {
            errorText.textContent = 'Harap pilih rating produk (1-5 bintang)';
            errorMsg.classList.remove('hidden');
            successMsg.classList.add('hidden');
            return;
        }

        submitBtn.disabled = true;
        submitBtn.textContent = 'Mengirim...';

        const formData = new FormData(form);

        try {
            const response = await fetch('{{ route("product.comment.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await response.json();

            if (response.ok) {
                successMsg.classList.remove('hidden');
                errorMsg.classList.add('hidden');
                form.reset();
                ratingInput.value = '';
                ratingLabel.textContent = 'Pilih rating (1-5 bintang)';
                stars.forEach(s => s.textContent = '☆');

                // Reload page after 2 seconds to show updated comments
                setTimeout(() => location.reload(), 2000);
            } else {
                errorText.textContent = data.message || 'Terjadi kesalahan saat mengirim komentar';
                errorMsg.classList.remove('hidden');
                successMsg.classList.add('hidden');
            }
        } catch (error) {
            errorText.textContent = 'Terjadi kesalahan jaringan. Silakan coba lagi.';
            errorMsg.classList.remove('hidden');
            successMsg.classList.add('hidden');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Kirim Komentar & Rating';
        }
    });
});
</script>
@endpush

@push('styles')
<style>
    .star-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        line-height: 1;
        transition: all 0.2s ease;
    }

    .star-btn:hover {
        transform: scale(1.2);
    }

    .star-btn.text-yellow-400 {
        color: #FBBF24;
    }
</style>
@endpush
