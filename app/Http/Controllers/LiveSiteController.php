<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use App\Models\Category;
use Session;
use \Ecommerce\helperFunctions;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LiveSiteController extends Controller
{

	    // MACHINE FRAMES
	    public function machine() { return view('frontend.pages.machine-frames.machine'); }
	    public function gqframe() { return view('frontend.pages.machine-frames.gq-frame'); }
	    public function compareMachineFrames() {return view('frontend.pages.machine-frames.compare-machine-frames'); }
	    public function comparison() {return view('frontend.pages.machine-frames.comparison'); }
	    public function accessories() {return view('frontend.pages.machine-frames.accessories'); }
	    public function graciekq() {return view('frontend.pages.machine-frames.gracie-kq'); }
	    public function sr2frame() {return view('frontend.pages.machine-frames.sr-2-frame'); }

	    // QNIQUE
	    public function qnique() {return view('frontend.pages.qnique.qnique'); }
	    public function qnique21() {return view('frontend.pages.qnique.qnique21'); }
	    public function qfeatures() {return view('frontend.pages.qnique.features'); }
	    public function qspecs() {return view('frontend.pages.qnique.specs'); }
	    public function qaccessories() {return view('frontend.pages.qnique.accessories'); }

	    // AUTOMATION
	    public function qct() {return view('frontend.pages.qct.qct'); }
	    public function qctfeatures() {return view('frontend.pages.qct.features'); }
	    public function qctcompare() {return view('frontend.pages.qct.compare'); }
	    public function qctspecs() {return view('frontend.pages.qct.specs'); }
	    public function qcttutorials() {return view('frontend.pages.qct.tutorials'); }
	    public function qctsupport() {return view('frontend.pages.qct.support'); }
	    public function qctpurchase() {return view('frontend.pages.qct.purchase'); }

	    // HAND QUILTING
	    public function handquilting() {return view('frontend.pages.hand-quilting.handquilting'); }
	    public function z44frame() {return view('frontend.pages.hand-quilting.z44-frame'); }
	    public function startrightez3() {return view('frontend.pages.hand-quilting.start-right-ez3'); }
	    public function gracehoop2() {return view('frontend.pages.hand-quilting.grace-hoop-2'); }
	    public function gracelaphoops() {return view('frontend.pages.hand-quilting.grace-lap-hoops'); }
	    public function graciebee() {return view('frontend.pages.hand-quilting.graciebee'); }
	    public function handaccessories() {return view('frontend.pages.hand-quilting.accessories'); }
	    public function comparehandframes() {return view('frontend.pages.hand-quilting.compare-frames'); }

	    // TRUECUT
	    public function truecut() {return view('frontend.pages.truecut.truecut'); }
	    public function comfort() {return view('frontend.pages.truecut.comfort-cutter'); }

	    public function cuttingMats() {return view('frontend.pages.truecut.cutting-mats');}
	    public function cuttingTable() {return view('frontend.pages.truecut.cutting-table');}
	    public function linearSharpener() {return view('frontend.pages.truecut.linear-sharpener');}
	    public function rotaryCuttingAccessories() {return view('frontend.pages.truecut.rotary-cutting-accessories');}
	    public function rulers() {return view('frontend.pages.truecut.rulers');}
	    public function truesharp() {return view('frontend.pages.truecut.truesharp');}
	    public function truecut360() {return view('frontend.pages.truecut.truecut360');}

		// ACCESSORIES
		public function addons() {return view('frontend.pages.addons.accessories'); }
		public function luminess() {return view('frontend.pages.addons.luminess'); }

}
