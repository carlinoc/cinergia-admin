<?php

namespace App\Http\Controllers;

use App\Models\WebSite;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File; 

class WebSiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('websites.index');
    }

    public function list(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $websites = WebSite::all();
            return response()->json(['websites' => $websites]);
        } else {
            abort(403, 'You do not have permission to view this page ');
        }
    }

    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required'
        ]);

        $slug = Str::slug($request->title);
        $path = 'files/websites/';

        $row = WebSite::where('slug', $slug)->get();
        if($row->count() == 0) {
            $website = new Website();
   
            if($request->hasFile('background')){
                $filename = time() .'-'. $slug . '-b.jpg';
                $success = $request->file('background')->move($path, $filename);
                if($success){
                    $website->background = $path . $filename;    
                }
            }

            if($request->hasFile('logo')){
                $filename1 = time() .'-'. $slug . '-l.png';
                $success1 = $request->file('logo')->move($path, $filename1);
                if($success1){
                    $website->logo = $path . $filename1;    
                }
            }

            $website->title = $request->title;
            $website->slug = $slug;
            $website->description = $request->description;
            $website->color1 = $request->color1;
            $website->color2 = $request->color2;
            $website->color3 = $request->color3;
            $website->color4 = $request->color4;

            $website->save();

            return response()->json(['status'=>'success', 'message'=>'La web fue agregada']);    
        }else{
            return response()->json(['status'=>'error', 'message'=>'El Slug ya existe']);
        }
    }

    public function edit(Request $request): JsonResponse 
    {
        $request->validate([
            'title' => 'required'
        ]);

        $slug = Str::slug($request->title);
        $path = 'files/websites/';

        $website = WebSite::where('id', $request->websiteId)->first();
        $background = $website->background;
        $logo = $website->logo;
        
        if(!is_null($background) && $request->hasFile('background')){
            File::delete($background);
        }
        if($request->hasFile('background')){
            $filename = time() .'-'. $slug . '-b.jpg';
            $success = $request->file('background')->move($path, $filename);
            if($success) {
                $background = $path . $filename;   
            }
        }

        if(!is_null($logo) && $request->hasFile('logo')){
            File::delete($logo);
        }
        if($request->hasFile('logo')){
            $filename1 = time() .'-'. $slug . '-l.png';
            $success1 = $request->file('logo')->move($path, $filename1);
            if($success1) {
                $logo = $path . $filename1;   
            }
        }

        WebSite::where('id', $request->websiteId)
            ->update(['title' => $request->title, 'slug' => $slug, 'description' => $request->description, 'background' => $background, 'logo' => $logo, 'color1' => $request->color1, 'color2' => $request->color2, 'color3' => $request->color3, 'color4' => $request->color4]);

        return response()->json(['status'=>'success', 'message'=>'La web fue actualizada']);
    }

    public function remove(Request $request): JsonResponse
    {
        $website = WebSite::where('id', $request->websiteId)->first();
        if($website->count() > 0){
            if(!is_null($website->background)){
                File::delete(public_path($website->background));
            }

            if(!is_null($website->logo)){
                File::delete(public_path($website->logo));
            }

            website::find($website->id)->delete();      

            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'error']);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WebSite $webSite)
    {
        //
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WebSite $webSite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WebSite $webSite)
    {
        //
    }
}
