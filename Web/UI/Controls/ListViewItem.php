<?php	
class ListViewItem extends Object //extends Component
{
	public $Checked;
	public $SubItems;
	private $ListViewId;
		
	function ListViewItem($objOrText = null)
	{
		$this->SubItems = new ImplicitArrayList($this, "AddSubItem");
		if($objOrText != null)
			$this->AddSubItem($objOrText);
	}
	function SetListView($listView)	{$this->ListViewId = $listView->Id;}
	function AddSubItem($objOrText=null)
	{
		$this->SubItems->Add((is_string($objOrText) || $objOrText == null)?$objOrText = new Label($objOrText, 0, 0, "100%"):$objOrText, true, true);
		$objOrText->SetCSSClass("NLVItem");
		if($this->ListViewId != null)
			GetComponentById($this->ListViewId)->Update($this);
	}
}		
?>