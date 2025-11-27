@component('mail::message')
# Terima Kasih Atas Komentar Anda!

Halo {{ $comment->visitor_name }},

Terima kasih telah meninggalkan komentar dan rating untuk produk **{{ $product->name }}** di CampusMarket.

## Detail Komentar Anda:
- **Rating**: ⭐ {{ $comment->rating }} dari 5 bintang
- **Komentar**: {{ $comment->comment ?? 'Tidak ada komentar tambahan' }}
- **Tanggal**: {{ $comment->created_at->format('d M Y H:i') }}

Tim kami akan memeriksa komentar Anda, dan setelah disetujui, komentar Anda akan ditampilkan di halaman produk untuk membantu pembeli lain membuat keputusan yang tepat.

Jika Anda memiliki pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami melalui email ini.

Terima kasih telah menjadi bagian dari komunitas CampusMarket!

@component('mail::button', ['url' => route('home')])
Kembali ke CampusMarket
@endcomponent

Salam,
**Tim CampusMarket**
@endcomponent
