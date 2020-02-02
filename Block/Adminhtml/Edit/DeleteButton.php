<?php
namespace MRYM\SalesManager\Block\Adminhtml\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends Button implements ButtonProviderInterface
{
    /**
     * Retrieve button-specified settings
     *
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        $id = $this->getId();
        if ($id && $this->canRender('delete')) {
            $data = [
                'label' => __('Delete Manager'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                        'Are you sure you want to do this?'
                    ) . '\', \'' . $this->urlBuilder->getUrl('*/*/delete', ['id' => $id]) . '\', {data: {}})',
                'sort_order' => 20,
            ];
        }

        return $data;
    }
}