<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once dirname(__file__).'/pdfmerger/PDFMerger.php';

class Pdfmerge extends PDFMerger {
    public function __construct()
    {
      parent::__construct();
    }


}
