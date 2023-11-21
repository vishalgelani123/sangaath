<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

use App\Models\Uservillage;
use App\Models\IncompleteForm;
use App\Models\ConfirmApplication;
use App\Models\Beneficiary;
use App\Models\kycDocument;
use App\Models\Scheme;

class DocumentationController extends Controller
{
    /**
     * Get the incomplete forms of the users
     *
     * @return \Inertia\Response
     */
    public function getIncomplete()
    {
        $user = request()->user();
        if ($user->hasRole('admin')) {
            $forms = IncompleteForm::with([
                "beneficiary" => function ($query) {
                    return $query->select("id", "member_id", "village_id", "name")->with("village:id,name");
                },
                "scheme",
                "village"
            ])->get();

        } else {
            $userId = request()->user()->id;
            $allotedVillages = Uservillage::where("user_id", $userId)
                ->has("village_name.site")
                ->with("village_name.site")
                ->get();

            $villageIds = $allotedVillages->pluck("village_id")
                ->toArray();

            $forms = IncompleteForm::whereIntegerInRaw("village_id", $villageIds)
                ->with([
                    "beneficiary" => function ($query) use ($villageIds) {
                        return $query->select("id", "member_id", "village_id", "name")
                            ->whereIntegerInRaw("village_id", $villageIds)
                            ->with("village:id,name");
                    },
                    "scheme"
                ])
                ->get();
        }
        return Inertia::render("Documentation/Incomplete", ["all_forms" => $forms]);
    }

    /**
     * Deletes the form from the storage
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleteIncompleteForm(Request $request)
    {
        $formId = $request->form_id;

        IncompleteForm::where("id", $formId)
            ->delete();

        return response()->success([]);
    }

    /**
     * Get the pending forms
     */
    public function getPending(Request $request)
    {
        $user = request()->user();
        if ($user->hasRole('admin')) {

            $formsQuery = ConfirmApplication::select("id", "documentation_date", "member_id", "created_at", "deleted_at", "village_id", "scheme_id")
                ->where("documentation_status", 0)
                ->orderBy("created_at", 'DESC');
            $formsQuery->with("beneficiary.village:id,name", "scheme:id,name");

            $formsQuery->with([
                "beneficiary" => function ($query) {
                    $query->select("id", "member_id", "village_id", "name");
                }
            ]);

            $search = $request->get("search");
            if ($search) {
                $formsQuery->where(function ($query) use ($search) {
                    $query->whereHas('beneficiary', function ($query) use ($search) {
                        $query->select("id", "member_id", "village_id", "name");
                        $query->where('name', 'LIKE', "%$search%")
                            ->orWhere('member_id', 'LIKE', "%$search%");
                    })
                        ->orWhereHas('beneficiary.village', function ($query) use ($search) {
                            $query->select("id", "name");
                            $query->where('name', 'LIKE', "%$search%");
                        })
                        ->orWhereHas('scheme', function ($query) use ($search) {
                            $query->select("id", "name");
                            $query->where('name', 'LIKE', "%$search%");
                        })
                        ->orWhereRaw("DATE_FORMAT(created_at, '%d %b %Y') LIKE ?", ["%$search%"]);
                });
            }

            $take = 50;
            $formsQuery->take($take);

            if ($request->get('is_ajax')) {
                $skip = $request->get("skip");
                $formsQuery->skip($skip);
            }

            $forms = $formsQuery->get()
                ->map(function ($application) {
                    return $application->format();
                });

            if ($request->get('is_ajax')) {
                return ["status" => 1, "rows" => $forms];
            }
        } else {
            $userId = request()->user()->id;
            $allotedVillages = Uservillage::where("user_id", $userId)
                ->has("village_name.site")
                ->get();

            $villageIds = $allotedVillages->pluck("village_id")
                ->toArray();

            $formsQuery = ConfirmApplication::select("id", "documentation_date", "member_id", "created_at", "deleted_at", "village_id", "scheme_id")
                ->where("documentation_status", 0)
                ->whereIntegerInRaw("village_id", $villageIds)
                ->orderBy("created_at", 'DESC');

            $formsQuery->with("beneficiary.village:id,name", "scheme:id,name");

            $formsQuery->with([
                "beneficiary" => function ($query) use ($villageIds) {
                    $query->whereIntegerInRaw("village_id", $villageIds);
                    $query->select("id", "member_id", "village_id", "name");
                }
            ]);

            $search = $request->get("search");
            if ($search) {
                $formsQuery->where(function ($query) use ($search) {
                    $query->whereHas('beneficiary', function ($query) use ($search) {
                        $query->select("id", "member_id", "village_id", "name");
                        $query->where('name', 'LIKE', "%$search%")
                            ->orWhere('member_id', 'LIKE', "%$search%");
                    })
                        ->orWhereHas('beneficiary.village', function ($query) use ($search) {
                            $query->select("id", "name");
                            $query->where('name', 'LIKE', "%$search%");
                        })
                        ->orWhereHas('scheme', function ($query) use ($search) {
                            $query->select("id", "name");
                            $query->where('name', 'LIKE', "%$search%");
                        })
                        ->orWhereRaw("DATE_FORMAT(created_at, '%d %b %Y') LIKE ?", ["%$search%"]);
                });
            }

            $take = 50;
            $formsQuery->take($take);

            if ($request->get('is_ajax')) {
                $skip = $request->get("skip");
                $formsQuery->skip($skip);
            }

            $forms = $formsQuery->get()
                ->map(function ($application) {
                    return $application->format();
                });

            if ($request->get('is_ajax')) {
                return ["status" => 1, "rows" => $forms];
            }
        }
        return Inertia::render("Documentation/Pending", ["initial_forms" => $forms]);
    }

    /**
     * Downloads the detail of the pending application
     *
     * @param int $formId
     * @return \Illuminate\Http\Response
     */
    public function downloadPendingDetails($formId)
    {
        $userId = request()->user()->id;
        $allotedVillages = Uservillage::where("user_id", $userId)
            ->has("village_name.site")
            ->with("village_name.site")
            ->get();

        $villageIds = $allotedVillages->pluck("village_id")
            ->toArray();

        $application = ConfirmApplication::where("id", $formId)
            ->with([
                "beneficiary" => function ($query) use ($villageIds) {
                    return $query->select("id", "member_id", "village_id", "name", "full_address")
                        ->whereIn("village_id", $villageIds)
                        ->with("village:id,name");
                },
                "scheme"
            ])
            ->first();

        $scheme = Scheme::select("id")
            ->where("id", $application->scheme_id)
            ->with("documents.pre_requisite:id,name")
            ->first();
        $documents = "";
        foreach ($scheme->documents as $document) {
            // dd($document);
            $documents .= '<li>' . $document->pre_requisite->name . '</li>';
        }
        $kycList = '<ol>' . $documents . '</ol>';
        $applicationNumber = $application->member_id . '-' . $application->scheme_id;

        $fileName = $application->beneficiary->name . " - Title Page";
        $headers = array(
            "Content-type"        => "text/html",
            "Content-Disposition" => "attachment;Filename=" . $fileName . ".doc"
        );
        $content = '<html>
            <head><meta charset="utf-8"></head>
            <body>
                <table style="width:100%">
                <thead>
                <tr align="center">
                <td colspan="2"><img src="http://app.deepakfoundation.org/logo/df_logo2.png" height="75" width="75">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <img src="http://app.deepakfoundation.org/logo/sangath_logo.png" height="80" width="80"></td>
                </tr>
                <tr align="center">
                    <td colspan="2">Deepak Foundation - Sangath Project <p style="font-size: 14px;color: green">Supported By - Deepak Phenolics Limited</p></td>
                </tr>
                </thead>
                <tbody>
                <tr align="center">
                    <td></td>
                    <td></td>
                </tr>
                <tr align="center">
                    <td colspan="2"><p style="font-size: 20px;color: green">"Project Title"</p></td>
                </tr>
                <tr align="center">
                    <td></td>
                    <td></td>
                </tr>
                <tr align="center">
                    <td colspan="2">*******************************************************************************</td>
                </tr>
                <tr align="center">
                    <td colspan="2"><p style="font-size: 25px;">Application Form</p></td>
                </tr>
                <tr align="center">
                    <td colspan="2">*******************************************************************************</td>
                </tr>
                <tr align="center">
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Date of Application : </td>
                    <td>' . date('d/m/Y') . '</td>
                </tr>
                <tr align="center">
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>1. Name of the Applicant :</td>
                    <td>' . $application->beneficiary->name . '<br>- Application No:' . $applicationNumber . '</td>
                </tr>
                <tr align="center">
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>2. Address of Applicant :</td>
                    <td>' . $application->beneficiary->full_address . '</td>
                </tr>
                <tr align="center">
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>3. Contact Number of Applicant :</td>
                    <td>+91-xxxxx-xxxxx</td>
                </tr>
                <tr align="center">
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>4. Scheme Applied :</td>
                    <td>' . $application->scheme->name . '</td>
                </tr>
                <tr>
                <tr align="center">
                    <td></td>
                    <td></td>
                </tr>
                    <td colspan="2">5. List of Documents Require </br>(Enclosed Documents) :</td>
                </tr>
                <tr>
                    <td colspan="2">' . $kycList . '</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td><strong>Signature of Applicant</strong></td>
                    <td><strong>Receiver’s Signature</strong></td>
                </tr>
                <tr>
                    <td>' . $application->beneficiary->name . '</td>
                    <td></td>
                </tr>
                <tr align="center">
                    <td></td>
                    <td></td>
                </tr>
                <tr align="center">
                    <td></td>
                    <td></td>
                </tr>
                <tr align="center">
                    <td colspan="2">Implementing Agency - Deepak Foundation
                    </td>
                </tr>
                <tr align="center">
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
                </table>
            </body>
            </html>';
        return Response::make($content, 200, $headers);
    }

    /**
     * Downloads the uploaded documents
     *
     * @param int $formId
     * @return \Illuminate\Http\Response
     */
    public function downloadPendingDocuments($formId)
    {
        $application = ConfirmApplication::select("id", "village_id", "hh_id", "member_id", "scheme_id")
            ->where("id", $formId)
            ->first();


        $beneficiary = Beneficiary::select("village_id", "hh_id", "member_id", "name")
            ->where([
                "village_id" => $application->village_id,
                "hh_id"      => $application->hh_id,
                "member_id"  => $application->member_id
            ])
            ->first();

        $villageId = $beneficiary->village_id;
        $hhId = $beneficiary->hh_id;
        $memberId = $beneficiary->member_id;
        $uploadedDocuments = kycDocument::where([
            "village_id" => $villageId,
            "hh_id"      => $hhId,
            "member_id"  => $memberId
        ])
            ->get()
            ->pluck("file_name", "prerequisite_id")
            ->toArray();

        $scheme = Scheme::select("id")
            ->where("id", $application->scheme_id)
            ->with("documents.pre_requisite:id,name")
            ->first();

        $zipFileName = $beneficiary->name . "-Documents.zip";
        $zipFilePath = public_path('zips/' . $zipFileName);

//        dd($zipFilePath);
        $zip = new \ZipArchive();
        $zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $zip->addFile(storage_path('app/public/df-logo.png'), "default.png");

        $requiredDocuments = $scheme->documents->keyBy("prerequisite_id")->toArray();
        foreach ($uploadedDocuments as $documentId => $fileName) {
            if (in_array($documentId, array_keys($requiredDocuments))) {
                $document = $requiredDocuments[$documentId];
                $filePath = storage_path('app/public/kycs/' . $fileName);

                if (file_exists($filePath)) {
                    $splitFileName = explode(".", $fileName);
                    $extension = end($splitFileName);

                    $zip->addFile($filePath, $document["pre_requisite"]["name"] . "." . $extension);
                } else {
                    dd("File not found: " . $filePath);
                }
            }
        }

        try {
            // ... your code for creating and adding files to the zip ...

            $zip->close();

            $currentTime = \Carbon\Carbon::now('Asia/Kolkata')->toDateTimeString();
            ConfirmApplication::where("id", $formId)
                ->update([
                    "documentation_status" => 1,
                    "documentation_date"   => $currentTime
                ]);

            return response()->success(["download_link" => url('/zips/' . $zipFileName)]);
        } catch (\Exception $e) {
            dd("Error during zip creation: " . $e->getMessage());
        }
    }

    /**
     * Deletes the pending form from the storage
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function deletePendingForm(Request $request)
    {
        $formId = $request->form_id;

        ConfirmApplication::where("id", $formId)
            ->delete();

        return response()->success([]);
    }

    /**
     * Get the complete forms of the users
     */
    public function getComplete(Request $request)
    {
        $user = request()->user();
        if ($user->hasRole('admin')) {

            $formsQuery = ConfirmApplication::select("id", "documentation_date", "member_id", "created_at", "deleted_at", "village_id", "scheme_id")
                ->where("documentation_status", 1)
                ->orderBy("created_at", 'DESC');

            $formsQuery->with("beneficiary.village:id,name", "scheme:id,name", "village");
            $formsQuery->with([
                "beneficiary" => function ($query) {
                    $query->select("id", "member_id", "village_id", "name");
                }
            ]);

            $search = $request->get("search");
            if ($search) {
                $formsQuery->where(function ($query) use ($search) {
                    $query->whereHas('beneficiary', function ($query) use ($search) {
                        $query->select("id", "member_id", "village_id", "name");
                        $query->where('name', 'LIKE', "%$search%")
                            ->orWhere('member_id', 'LIKE', "%$search%");
                    })
                        ->orWhereHas('beneficiary.village', function ($query) use ($search) {
                            $query->select("id", "name");
                            $query->where('name', 'LIKE', "%$search%");
                        })
                        ->orWhereHas('scheme', function ($query) use ($search) {
                            $query->select("id", "name");
                            $query->where('name', 'LIKE', "%$search%");
                        })
                        ->orWhereRaw("DATE_FORMAT(created_at, '%d %b %Y') LIKE ?", ["%$search%"]);
                });
            }

            $take = 50;
            $formsQuery->take($take);

            if ($request->get('is_ajax')) {
                $skip = $request->get("skip");
                $formsQuery->skip($skip);
            }

            $forms = $formsQuery->get()
                ->map(function ($application) {
                    return $application->format();
                });
            if ($request->get('is_ajax')) {
                return ["status" => 1, "rows" => $forms];
            }

        } else {
            $userId = request()->user()->id;
            $allotedVillages = Uservillage::where("user_id", $userId)
                ->has("village_name.site")
                ->get();

            $villageIds = $allotedVillages->pluck("village_id")
                ->toArray();

            $formsQuery = ConfirmApplication::select("id", "documentation_date", "member_id", "created_at", "deleted_at", "village_id", "scheme_id")
                ->where("documentation_status", 1)
                ->whereIntegerInRaw("village_id", $villageIds)
                ->orderBy("created_at", 'DESC');

            $formsQuery->with("beneficiary.village:id,name", "scheme:id,name");
            $formsQuery->with([
                "beneficiary" => function ($query) use ($villageIds) {
                    $query->whereIntegerInRaw("village_id", $villageIds);
                    $query->select("id", "member_id", "village_id", "name");
                }
            ]);

            $search = $request->get("search");
            if ($search) {
                $formsQuery->where(function ($query) use ($search) {
                    $query->whereHas('beneficiary', function ($query) use ($search) {
                        $query->select("id", "member_id", "village_id", "name");
                        $query->where('name', 'LIKE', "%$search%")
                            ->orWhere('member_id', 'LIKE', "%$search%");
                    })
                        ->orWhereHas('beneficiary.village', function ($query) use ($search) {
                            $query->select("id", "name");
                            $query->where('name', 'LIKE', "%$search%");
                        })
                        ->orWhereHas('scheme', function ($query) use ($search) {
                            $query->select("id", "name");
                            $query->where('name', 'LIKE', "%$search%");
                        })
                        ->orWhereRaw("DATE_FORMAT(created_at, '%d %b %Y') LIKE ?", ["%$search%"]);
                });
            }

            $take = 50;
            $formsQuery->take($take);

            if ($request->get('is_ajax')) {
                $skip = $request->get("skip");
                $formsQuery->skip($skip);
            }

            $forms = $formsQuery->get()
                ->map(function ($application) {
                    return $application->format();
                });

            if ($request->get('is_ajax')) {
                return ["status" => 1, "rows" => $forms];
            }
        }

        return Inertia::render("Documentation/Complete", ["initial_forms" => $forms]);
    }

    /**
     * Deletes the form from the storage
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleteCompleteForm(Request $request)
    {
        $formId = $request->form_id;

        ConfirmApplication::where("id", $formId)
            ->delete();

        return response()->success([]);
    }
}
