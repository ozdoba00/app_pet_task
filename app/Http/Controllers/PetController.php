<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;

class PetController extends Controller
{
    /** STATUS SECTION */

    /**
     * @param Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function findByStatus(Request $request): \Illuminate\Http\JsonResponse
    {
        try 
        {
            $request->validate([
                'status' => 'required|in:available,pending,sold',
            ]);

            $status = $request->input('status');
            $response = Http::get("https://petstore.swagger.io/v2/pet/findByStatus?status=$status");

            if ($response->successful()) 
            {
                $pets = $response->json();
                return response()->json($pets);
            }
            else 
            {
                return response()->json(['error' => 'Failed to fetch pet'], $response->status());
            }

        } 
        catch (\Throwable $e) 
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @return View|Factory
     */
    public function showFindPetsByStatusForm(): View|Factory
    {
        return view('findPetsByStatus');
    }
    /** STATUS SECTION */


    /** ID SECTION */

    /**
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function findById(Request $request): JsonResponse
    {
        try 
        {
            $request->validate([
                'id' => 'required|numeric|min:1',
            ]);

            $petId = $request->input('id');

            $response = Http::get("https://petstore.swagger.io/v2/pet/$petId");

            if ($response->successful()) 
            {
                $pet = $response->json();
                return response()->json($pet);
            } 
            else 
            {
                return response()->json(['error' => 'Failed to fetch pet'], $response->status());
            }

        } 
        catch (\Throwable $e) 
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @return View|Factory
     */
    public function showFindPetsByIdForm(): View|Factory
    {
        return view('findPetsById');
    }
    /** ID SECTION */

    /** STORE PET SECTION */

    /**
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function addPet(Request $request): JsonResponse
    {
        try 
        {
            $request->validate([
                'id' => 'required|numeric|min:1',
                'name' => 'required|string',
                'status' => 'required|string',
                'tags' => 'nullable|string|max:255'
            ]);

            $data = collect($request->all());
            $tags = htmlspecialchars($request->input('tags'));
            $filteredTags = collect(explode(',', $tags))->map(function ($tag, $index) 
            {
                return ['id' => $index + 1, 'name' => $tag];
            });

            $data['tags'] = $filteredTags->all();

            $response = Http::post("https://petstore.swagger.io/v2/pet", $data->all());

            if ($response->successful()) 
            {
                $pet = $response->json();
                return response()->json($pet);
            } 
            else 
            {
                return response()->json(['error' => 'Failed to fetch pet'], $response->status());
            }

        } 
        catch (\Throwable $e) 
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @return View|Factory
     */
    public function showAddPetForm(): View|Factory
    {
        return view('addPet');
    }
    /** STORE PET SECTION */

    /** UPDATE PET SECTION */

    /**
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function updatePet(Request $request): JsonResponse
    {
        try 
        {
            $request->validate([
                'id' => 'required|numeric|min:1',
                'name' => 'required|string',
                'status' => 'required|string',
                'tags' => 'nullable|string|max:255'
            ]);
    
            $data = collect($request->all());
            $tags = htmlspecialchars($request->input('tags'));
            $filteredTags = collect(explode(',', $tags))->map(function ($tag, $index) 
            {
                return ['id' => $index + 1, 'name' => $tag];
            });
    
            $data['tags'] = $filteredTags->all();
    
            $response = Http::put("https://petstore.swagger.io/v2/pet", $data->all());

            if ($response->successful()) 
            {
                $pet = $response->json();
                return response()->json($pet);
            } 
            else 
            {
                return response()->json(['error' => 'Failed to fetch pet'], $response->status());
            }

        } 
        catch (\Throwable $e) 
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }  
    }

    /**
     * @return View|Factory
     */
    public function showUpdatePetForm()
    {
        return view('updatePet');
    }

    /** UPDATE PET SECTION */

    /** IMAGE PET SECTION */

    /**
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function addImagePet(Request $request): JsonResponse
    {
        try 
        {
            $request->validate([
                'id' => 'required|numeric|min:1'
            ]);
            
            if ($request->hasFile('image')) 
            {
                $image = $request->file('image');

                $petId = $request->input('id');

                $response = Http::attach(
                    'file', 
                    file_get_contents($image), 
                    $image->getClientOriginalName()
                )->post("https://petstore.swagger.io/v2/pet/{$petId}/uploadImage");

                // Sprawdzenie odpowiedzi z API
                if ($response->successful()) 
                {
                    return response()->json(['message' => 'Image uploaded successfully'], 200);
                } 
                else 
                {
                    return response()->json(['message' => 'Failed to upload image'], $response->status());
                }

            } 
            else 
            {
                return response()->json(['message' => 'No image file uploaded'], 400);
            }

        } 
        catch (\Exception $e) 
        {
            return response()->json(['message' => 'Error uploading image: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @return View|Factory
     */
    public function showAddImagePetForm(): View|Factory
    {
        return view('addPetImage');
    }

    /** IMAGE PET SECTION */

    /** DELETE PET SECTION */

    /**
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function deletePet(Request $request): JsonResponse
    {
        try 
        {
            $request->validate([
                'id' => 'required|numeric|min:1',
            ]);
            $petId = $request->input('id');
            $response = Http::delete("https://petstore.swagger.io/v2/pet/$petId");
            if ($response->successful()) 
            {
                $pet = $response->json();
                return response()->json($pet);
            } 
            else 
            {
                return response()->json(['error' => 'Failed to fetch pet'], $response->status());
            }

        } 
        catch (\Throwable $e) 
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }  
    }

    /**
     * @return View|Factory
     */
    public function showDeletePetForm(): View|Factory
    {
        return view('deletePet');
    }

    /** DELETE PET SECTION */
}
