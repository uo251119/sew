<?php
class ResourceController extends BaseController
{
    /**
     * Get list of resources
     */
    public function getResources($id = "", $limit = "")
    {
        try {
            $resourceModel = new ResourceModel();

            if (empty($id)) {
                if (!empty($limit)) {
                    $arrResources = $resourceModel->getResources($limit);
                } else {
                    $arrResources = $resourceModel->getResources();
                }
            } else {
                $arrResources = $resourceModel->getResource($id);
            }

            $responseData = json_encode($arrResources);

        } catch (Error $e) {
            return json_encode(["message" => $e, "error" => true]);
        }

        return $responseData;
    }

    /**
     * Post - set one resource to table
     */
    public function setResources($data)
    {
        try {
            $resourceModel = new ResourceModel();

            $arrResources = $resourceModel->setResources($data);
            $responseData = json_encode($arrResources);

        } catch (Error $e) {
            return json_encode(["message" => $e, "error" => true]);
        }

        return $responseData;
    }

    /**
     * PUT - change data resource to table
     */
    public function putResources($data, $id)
    {

        try {
            $resourceModel = new ResourceModel();

            $arrResources = $resourceModel->updateResources($data, $id);
            $responseData = json_encode($arrResources);

        } catch (Error $e) {
            return json_encode(["message" => $e, "error" => true]);
        }

        return $responseData;
    }

    /**
     * DELETE - delete one resource to table
     */
    public function deleteResources($id)
    {

        try {
            $resourceModel = new ResourceModel();
            $arrResources = $resourceModel->deleteResources($id);

            $responseData = json_encode($arrResources);
        } catch (Error $e) {
            return json_encode(["message" => $e, "error" => true]);
        }

        return $responseData;
    }

    public function goToHome($result)
    {
        $response = "";

        if ($result->insert) {
            $currentLink = "../php/reservas.php";
            header('Location: ' . $currentLink);
        } else {
            $response = json_encode($result->response);
            $currentLink = "../php/reservas.php?failed=" . $response;
            header('Location: ' . $currentLink);
        }
    }
}