<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->onDelete('cascade');

            // Tipo: customer / supplier / both
            $table->enum('type', ['customer', 'supplier', 'both']);

            // Información básica
            $table->string('company_name')->nullable(); // Si es empresa/proveedor
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('full_name')->nullable(); // Puede generarse automáticamente

            // Documento fiscal
            $table->string('tax_id_type')->nullable(); // ['CI', 'NIT', 'CEX', 'PAS']
            $table->string('tax_id_number')->nullable();
            $table->string('tax_name')->nullable(); // Razon social

            // Contacto
            $table->string('email')->nullable();
            $table->string('phone_mobile')->nullable();
            $table->string('phone_landline')->nullable();
            $table->string('phone_alternate')->nullable();

            // Dirección
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable()->default('Bolivia');
            $table->string('zip_code')->nullable();
            $table->text('shipping_address')->nullable();

            // Datos financieros
            $table->decimal('opening_balance', 14, 2)->nullable()->default(0.00);
            $table->decimal('credit_limit', 14, 2)->nullable();
            $table->unsignedInteger('payment_term_value')->nullable(); // Ej: 30
            $table->enum('payment_term_type', ['days', 'months'])->nullable();

            // Control
            $table->foreignId('customer_group_id')->nullable()->constrained('customer_groups');
            $table->boolean('is_default')->default(false);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignId('created_by')->nullable()->constrained('users');

            $table->timestamps();
            $table->softDeletes(); // Para auditoría
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
