<?php

require_once "./GeradorDePixEstatico/qrlib.php"; 
require_once "./GeradorDePixEstatico/funcoes_pix.php";

class GeradorDePixEstatico
{
    private $ChavePixDoBeneficiario;
    private $ValorDoPix;

    function __construct(string $chavePixDoBeneficiario, $valorDoPix)
    {
        $this->ChavePixDoBeneficiario = $chavePixDoBeneficiario;
        $this->ValorDoPix = $valorDoPix;
    }

    function GetString()
    {
        $px[00]="01";
        $px[26][00]="BR.GOV.BCB.PIX";
        $px[26][01]= $this->ChavePixDoBeneficiario;
        $px[52]="0000";
        $px[53]="986";
        $px[54]= $this->ValorDoPix;
        $px[58]="BR";
        $px[59]="WebPay";
        $px[60]="***";
        $px[62][05]="***";
        $pix=montaPix($px);
        $pix.="6304";
        $pix.=crcChecksum($pix);

        return $pix;
    }
}

$GeradorDePix = new GeradorDePixEstatico("CHAVE_PIX", "45.00");
$pixString = $GeradorDePix->GetString();

// html
echo '<img width="140" height="140" src="https://dyn-qrcode.vercel.app/api?url='.$pixString.'" />';
echo "<hr>";
echo $pixString;