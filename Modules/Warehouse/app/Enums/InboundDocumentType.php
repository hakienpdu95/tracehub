<?php

namespace Modules\Warehouse\Enums;

enum InboundDocumentType: string
{
    case CustomsDeclaration = 'customs_declaration';
    case CoCertificate      = 'co_cert';
    case VatInvoice         = 'vat_invoice';

    public function label(): string
    {
        return match ($this) {
            self::CustomsDeclaration => 'Tờ khai hải quan',
            self::CoCertificate      => 'Giấy chứng nhận xuất xứ (C/O)',
            self::VatInvoice         => 'Hóa đơn VAT',
        };
    }
}
