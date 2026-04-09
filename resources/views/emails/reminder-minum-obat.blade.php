@component('mail::message')
# Halo, {{ $pasien->name }}!

Ini adalah pengingat bahwa sudah waktunya kamu minum obat.

@component('mail::panel')
**Obat:** {{ $namaObat }}  
**Waktu Minum:** {{ $waktu }}  
**Catatan:** {{ $jadwal->deskripsi ?? '-' }}
@endcomponent

Jaga kesehatanmu dan minum obat tepat waktu ya.

Salam,
{{ config('app.name') }}
@endcomponent
