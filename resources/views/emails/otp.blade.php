<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kode OTP HealTack</title>
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:'Segoe UI',Arial,sans-serif;">

  <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 16px;">
    <tr>
      <td align="center">
        <table width="100%" cellpadding="0" cellspacing="0" style="max-width:480px;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08);">

          <tr>
            <td style="background:#0C1D3B;padding:28px 32px;text-align:center;">
              <span style="font-size:24px;font-weight:800;color:#ffffff;letter-spacing:-.5px;">
                Heal<span style="color:#60A5FA;">Tack</span>
              </span>
            </td>
          </tr>

          <tr>
            <td style="padding:36px 32px;">

              <p style="margin:0 0 8px 0;font-size:18px;font-weight:700;color:#0C1D3B;">
                Verifikasi Akun Kamu
              </p>
              <p style="margin:0 0 24px 0;font-size:14px;color:#64748B;line-height:1.6;">
                Gunakan kode OTP berikut untuk menyelesaikan verifikasi akun HealTack kamu.
              </p>

              <table width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 24px 0;">
                <tr>
                  <td align="center">
                    <div style="display:inline-block;background:#EBF2FF;border-radius:14px;padding:18px 36px;">
                      <span style="font-size:42px;font-weight:800;color:#1A56DB;letter-spacing:12px;">
                        {{ $otp }}
                      </span>
                    </div>
                  </td>
                </tr>
              </table>

              <table width="100%" cellpadding="0" cellspacing="0" style="background:#FFFBEB;border-radius:10px;margin:0 0 20px 0;">
                <tr>
                  <td style="padding:14px 16px;">
                    <p style="margin:0;font-size:13px;color:#92400E;line-height:1.5;">
                      Kode ini berlaku selama <strong>10 menit</strong>.<br>
                      Jangan bagikan kode ini kepada siapa pun, termasuk tim HealTack.
                    </p>
                  </td>
                </tr>
              </table>

              <p style="margin:0;font-size:13px;color:#94A3B8;line-height:1.5;">
                Jika kamu tidak meminta kode ini, abaikan email ini. Akun kamu tetap aman.
              </p>

            </td>
          </tr>

          <tr>
            <td style="background:#F8FAFC;padding:20px 32px;text-align:center;border-top:1px solid #E2E8F0;">
              <p style="margin:0;font-size:12px;color:#94A3B8;">
                &copy; {{ date('Y') }} HealTack. All rights reserved.
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>
