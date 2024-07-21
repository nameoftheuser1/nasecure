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

        Schema::table('students', function (Blueprint $table) {
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('set null');
        });

        Schema::table('class_sessions', function (Blueprint $table) {
            $table->foreign('instructor_id')->references('id')->on('instructors')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });

        Schema::table('attendance_logs', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');
            $table->foreign('instructor_id')->references('id')->on('instructors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['section_id']);
        });

        Schema::table('class_sessions', function (Blueprint $table) {
            $table->dropForeign(['instructor_id']);
            $table->dropForeign(['course_id']);
        });

        Schema::table('attendance_logs', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropForeign(['instructor_id']);
        });
    }
};
