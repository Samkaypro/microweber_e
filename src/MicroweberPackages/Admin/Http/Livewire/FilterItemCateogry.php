<?php

namespace MicroweberPackages\Admin\Http\Livewire;

use MicroweberPackages\Category\Models\Category;
use MicroweberPackages\Page\Models\Page;

class FilterItemCateogry extends DropdownComponent
{
    public $name = 'Category';
    public string $view = 'admin::livewire.filters.filter-item-category';

    public $itemCategoryValue;
    public $itemPageValue;

    public $firstItemCategoryName;
    public $firstItemPageName;

    public $itemCategoryValueKey = 'category';
    public $itemPageValueKey = 'page';

    public $selectedItemsCount = 0;

    public function calculateSelectedItemsCount()
    {
        $this->selectedItemsCount = 0;
        $explode = explode(',', $this->itemCategoryValue);
        $explode = array_filter($explode);
        if (!empty($explode)) {
            $this->selectedItemsCount = count($explode);
        }

        $explode = explode(',', $this->itemPageValue);
        $explode = array_filter($explode);
        if (!empty($explode)) {
            $this->selectedItemsCount = $this->selectedItemsCount + count($explode);
        }

    }

    public function updatedItemCategoryValue($categoryIds)
    {
        $explode = explode(',', $categoryIds);
        $explode = array_filter($explode);
        if (!empty($explode)) {
            foreach ($explode as $categoryId) {
                $findCategory = Category::where('id', $categoryId)->first();
                if ($findCategory !== null) {
                    $this->firstItemCategoryName = $findCategory->title;
                }
            }
        }

        $this->showDropdown($this->id);
        $this->calculateSelectedItemsCount();
        $this->emitEvents();

    }

    public function updatedItemPageValue($pageIds)
    {
        $explode = explode(',', $pageIds);
        $explode = array_filter($explode);
        if (!empty($explode)) {
            foreach ($explode as $pageId) {
                $findPage = Page::where('id', $pageId)->first();
                if ($findPage !== null) {
                    $this->firstItemPageName = $findPage->title;
                }
            }
        }

        $this->showDropdown($this->id);
        $this->calculateSelectedItemsCount();
        $this->emitEvents();
    }

    public function hideFilterItem($id)
    {
        if ($this->id == $id) {
            $this->emit('hideFilterItem', strtolower($this->name));
            // $this->resetProperties();
        }
    }


    public function emitEvents()
    {
        $this->emit('autoCompleteSelectItem', $this->itemCategoryValueKey, $this->itemCategoryValue);
        $this->emit('autoCompleteSelectItem', $this->itemPageValueKey, $this->itemPageValue);
    }

/*    protected function getListeners()
    {
        return array_merge($this->listeners, [

        ]);
    }*/

}
