<?php
class TypeController extends BaseController
{
    /**
     * "/types" Endpoint - Get list of types
     */
    public function getTypes($id = "", $limit = "")
    {
        try {
            $typeModel = new TypeModel();

            if (empty($id)) {
                if (!empty($limit)) {
                    $arrTypes = $typeModel->getTypes($limit);
                } else {
                    $arrTypes = $typeModel->getTypes();
                }
            } else {
                $arrTypes = $typeModel->getType($id);
            }

            $responseData = json_encode($arrTypes);

        } catch (Error $e) {
            return json_encode(["message" => $e, "error" => true]);
        }

        return $responseData;
    }

}