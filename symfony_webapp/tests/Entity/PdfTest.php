<?php
namespace App\Tests\Entity;

use App\Entity\Pdf;
use PHPUnit\Framework\TestCase;

class PdfTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $Pdf = new Pdf();

        $Pdf->setTitle('title');
        $this->assertEquals('title', $Pdf->getTitle());

        $Pdf->setCreatedAt(new \DateTimeImmutable());
        $this->assertInstanceOf(\DateTimeImmutable::class, $Pdf->getCreatedAt());

        $Pdf->setUser(null);
        $this->assertEquals(null, $Pdf->getUser());
    }
}
?>