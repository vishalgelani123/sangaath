<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Household;
use App\Models\Beneficiary;
use App\Models\IncompleteForm;
use App\Models\ConfirmApplication;
use App\Models\kycDocument;

class ApplicationController extends Controller
{
    /**
     * Save the incomplete application in storage
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function saveIncomplete(Request $request)
    {
        $memberRowId = $request->member_row_id;
        $schemeId = $request->scheme_id;
        $selectedDocuments = json_decode($request->selected_documents, true);
        $formId = $request->form_id;

        $beneficiary = Beneficiary::select("id", "village_id", "hh_id", "member_id")
            ->where("id", $memberRowId)
            ->first();

        foreach($selectedDocuments as $documentId) {
            $image = $request->file("document_".$documentId);

            if ($image) {
                $imageName = $beneficiary->member_id."-".$documentId."-".time().".".$image->extension();
                $image->move("storage/kycs", $imageName);

                $isDocumentAvailable = kycDocument::where([
                    "village_id" => $beneficiary->village_id,
                    "hh_id" => $beneficiary->hh_id,
                    "member_id" => $beneficiary->member_id,
                    "prerequisite_id" => $documentId
                ])
                    ->exists();


                if (!$isDocumentAvailable) {
                    $document = new kycDocument;
                    $document->village_id = $beneficiary->village_id;
                    $document->hh_id = $beneficiary->hh_id;
                    $document->member_id = $beneficiary->member_id;
                    $document->prerequisite_id = $documentId;
                    $document->file_name = $imageName;
                    $document->save();
                }
            }
        }

        if ($formId == null) {
            $form = new IncompleteForm;
            $form->helpdesk_user = $request->user()->id;
            $form->village_id = $beneficiary->village_id;
            $form->hh_id = $beneficiary->hh_id;
            $form->member_id = $beneficiary->member_id;
            $form->scheme_id = $schemeId;
            $form->status = "incomplete";
            $form->save();
        }

        return response()->success([]);
    }

    /**
     * Skip the normal process and directly apply for the scheme
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function skipApply(Request $request)
    {
        $memberRowId = $request->member_row_id;
        $schemeId = $request->scheme_id;
        $eligibleStatus = $request->eligible_status;
        $formId = $request->form_id;
        $selectedDocuments = json_decode($request->selected_documents, true);

        $beneficiary = Beneficiary::select("id", "village_id", "hh_id", "member_id")
            ->where("id", $memberRowId)
            ->first();

        foreach($selectedDocuments as $documentId) {
            $image = $request->file("document_".$documentId);

            if ($image) {
                $imageName = $beneficiary->member_id."-".$documentId."-".time().".".$image->extension();
                $image->move("storage/kycs", $imageName);

                $isDocumentAvailable = kycDocument::where([
                    "village_id" => $beneficiary->village_id,
                    "hh_id" => $beneficiary->hh_id,
                    "member_id" => $beneficiary->member_id,
                    "prerequisite_id" => $documentId
                ])
                    ->exists();


                if (!$isDocumentAvailable) {
                    $document = new kycDocument;
                    $document->village_id = $beneficiary->village_id;
                    $document->hh_id = $beneficiary->hh_id;
                    $document->member_id = $beneficiary->member_id;
                    $document->prerequisite_id = $documentId;
                    $document->file_name = $imageName;
                    $document->save();
                }
            }
        }

        if ($formId != null) {
            // Delete the incomplete version of this form
            IncompleteForm::where("id", $formId)
                ->delete();
        }


        $application = new ConfirmApplication;
        $application->helpdesk_user = $request->user()->id;
        $application->village_id = $beneficiary->village_id;
        $application->hh_id = $beneficiary->hh_id;
        $application->member_id = $beneficiary->member_id;
        $application->scheme_id = $schemeId;
        $application->eligible_status = "Skipped_&_Apply";
        $application->save();

        return response()->success([]);
    }
}
