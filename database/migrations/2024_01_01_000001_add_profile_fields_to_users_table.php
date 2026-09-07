<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('city_id')->nullable()->after('id')->constrained('cities')->nullOnDelete();
            $table->string('address', 500)->nullable()->after('number');
            $table->date('date_of_birth')->nullable()->after('address');
            $table->enum('gender', ['Male', 'Female', 'Other', 'Prefer not to say'])->nullable()->after('date_of_birth');
            $table->string('profile_picture')->nullable()->after('gender');
            $table->enum('account_status', ['Active', 'Inactive'])->default('Active')->after('user_type');
            $table->timestamp('email_verified_at')->nullable()->after('email');
            $table->timestamp('last_login_at')->nullable()->after('account_status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('city_id');
            $table->dropColumn([
                'address',
                'date_of_birth',
                'gender',
                'profile_picture',
                'account_status',
                'email_verified_at',
                'last_login_at',
            ]);
        });
    }
};
