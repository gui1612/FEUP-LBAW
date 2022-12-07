<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    public function showAboutPage() {
      return view('pages.static.about');
    }

    public function showContactPage() {
      return view('pages.static.contact');
    }

    public function showFeaturesPage() {
      return view('pages.static.features');  
    }
}