<?php

namespace Tests\Feature;

use App\Http\Controllers\BankController;
use PHPUnit\Framework\TestCase;

class BankTest extends TestCase
{
    public function testValidaIBAN()
    {
        $controller = new BankController();
        // Asegúrate de que los IBANs sean válidos y correctos para pruebas
        $this->assertTrue($controller->validaIBAN('ES7620770024003102575766'));  // IBAN válido
        $this->assertFalse($controller->validaIBAN('ES7620770024003102575761')); // IBAN inválido
    }

    public function testDescobreixIBAN()
    {
        $controller = new BankController();
        $this->assertEquals('ES7620770024003102575766', $controller->descobreixIBAN('ES76207700240031025757**'));
    }
}
