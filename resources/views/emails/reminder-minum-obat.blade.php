@component('mail::message')

<div style="text-align:center; padding: 12px 0 24px;">
  <img src="{{ asset('images/healtack-logo.png') }}" alt="HealTack" height="36">
</div>

Halo, **{{ $pasien->name }}**!

Semoga harimu menyenangkan. Berikut pengingat jadwal minum obatmu hari ini.

@component('mail::panel')
<table style="width:100%; font-size:14px; border-collapse:collapse;">
  <tr>
    <td style="padding:6px 0; color:#6b7280; width:40%;">Nama Obat</td>
    <td style="padding:6px 0; font-weight:600;">{{ $namaObat }}</td>
  </tr>
  <tr>
    <td style="padding:6px 0; color:#6b7280;">Waktu Minum</td>
    <td style="padding:6px 0; font-weight:600;">
      {{ \Carbon\Carbon::parse($waktu)->translatedFormat('d M Y, H:i') }} WIB
    </td>
  </tr>
  @if($jadwal->deskripsi)
  <tr>
    <td style="padding:6px 0; color:#6b7280;">Catatan</td>
    <td style="padding:6px 0;">{{ $jadwal->deskripsi }}</td>
  </tr>
  @endif
</table>
@endcomponent

> Jika ada keluhan atau reaksi tidak biasa setelah minum obat, segera hubungi dokter.

Pastikan obat diminum tepat waktu agar manfaatnya tetap optimal.

Salam hangat,  
**Tim HealTack**

@component('mail::subcopy')
Email ini dikirim secara otomatis. Mohon tidak membalas email ini.
@endcomponent

@endcomponent
