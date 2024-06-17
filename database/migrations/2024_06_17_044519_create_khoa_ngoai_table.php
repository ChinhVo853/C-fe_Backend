<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nguoi_dung', function (Blueprint $table) {
            $table->foreign('quyen_id')->references('id')->on('quyen');
        });

        Schema::table('mon_an', function (Blueprint $table) {
            $table->foreign('size_id')->references('id')->on('size');
        });

        Schema::table('mon_an', function (Blueprint $table) {
            $table->foreign('loai_id')->references('id')->on('loai');
        });

        Schema::table('dat_mon', function (Blueprint $table) {
            $table->foreign('ban_id')->references('id')->on('ban');
        });

        Schema::table('chi_tiet_dat_mon', function (Blueprint $table) {
            $table->foreign('dat_mon_id')->references('id')->on('dat_mon');
        });

        Schema::table('chi_tiet_dat_mon', function (Blueprint $table) {
            $table->foreign('mon_an_id')->references('id')->on('mon_an');
        });

        Schema::table('ban', function (Blueprint $table) {
            $table->foreign('trang_thai_id')->references('id')->on('trang_thai');
        });

        Schema::table('yeu_cau', function (Blueprint $table) {
            $table->foreign('dat_mon_id')->references('id')->on('dat_mon');
        });

        Schema::table('hoa_don', function (Blueprint $table) {
            $table->foreign('dat_mon_id')->references('id')->on('dat_mon');
        });

        Schema::table('chi_tiet_hoa_don', function (Blueprint $table) {
            $table->foreign('hoa_don_id')->references('id')->on('hoa_don');
        });

        Schema::table('chi_tiet_hoa_don', function (Blueprint $table) {
            $table->foreign('mon_an_id')->references('id')->on('mon_an');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('khoa_ngoai');
    }
};
