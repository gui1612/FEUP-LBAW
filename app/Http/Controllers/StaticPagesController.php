<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    public function showAboutPage() {
      view('pages.static.about');
    }

    public function showContactPage() {
      view('pages.static.contact');
    }

    public function showFeaturesPage() {
      view('pages.static.features');  
    }
}