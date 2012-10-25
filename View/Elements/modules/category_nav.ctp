<?php
/**
 * @brief build the category navigation markup
 */
if(empty($shopCategoriesNav)) {
	return;
}

echo $this->Shop->categoryList($shopCategoriesNav, array('class' => 'nav'));
