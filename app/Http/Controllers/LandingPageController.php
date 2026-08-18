<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LandingPage;
use Illuminate\Support\Facades\Validator;

class LandingPageController extends Controller
{
    public function edit()
    {
        $landing = LandingPage::current();
        return view('dashboard.EditLandingPage', compact('landing'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hero_badge_1' => 'nullable|string|max:100',
            'hero_badge_2' => 'nullable|string|max:100',
            'hero_badge_3' => 'nullable|string|max:100',
            'hero_title_line1' => 'nullable|string|max:100',
            'hero_title_highlight' => 'nullable|string|max:100',
            'hero_title_line2' => 'nullable|string|max:100',
            'hero_description' => 'nullable|string',
            'hero_btn_primary_text' => 'nullable|string|max:50',
            'hero_btn_secondary_text' => 'nullable|string|max:50',
            'hero_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'drama_tag' => 'nullable|string|max:100',
            'drama_title' => 'nullable|string|max:100',
            'drama_desc' => 'nullable|string',
            'artikel_tag' => 'nullable|string|max:100',
            'artikel_title' => 'nullable|string|max:100',
            'artikel_desc' => 'nullable|string',
            'footer_brand_short' => 'nullable|string|max:10',
            'footer_brand_name' => 'nullable|string|max:100',
            'footer_description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $landing = LandingPage::current();

        if ($request->hasFile('hero_image')) {
            $uploadPath = public_path('uploads/landing');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            if ($landing->hero_image && file_exists(public_path($landing->hero_image))) {
                unlink(public_path($landing->hero_image));
            }

            $file = $request->file('hero_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move($uploadPath, $filename);
            $landing->hero_image = 'uploads/landing/' . $filename;
        }

        $landing->fill($request->except('hero_image'));
        $landing->save();

        // Ganti dashboard.landing-page menjadi admin.landing-page
        return redirect()->route('admin.landing-page')
            ->with('success', 'Landing page berhasil diperbarui!');
    }
}