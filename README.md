laravel-4-resource-compress
===============

[![Build Status](https://travis-ci.org/D3Catalyst/laravel-4-resource-compress.svg?branch=master)](https://travis-ci.org/D3Catalyst/laravel-4-resource-compress) [![Latest Stable Version](https://poser.pugx.org/d3catalyst/l4-resource-compress/v/stable.svg)](https://packagist.org/packages/d3catalyst/l4-resource-compress) [![Total Downloads](https://poser.pugx.org/d3catalyst/l4-resource-compress/downloads.svg)](https://packagist.org/packages/d3catalyst/l4-resource-compress) [![Latest Unstable Version](https://poser.pugx.org/d3catalyst/l4-resource-compress/v/unstable.svg)](https://packagist.org/packages/d3catalyst/l4-resource-compress) [![License](https://poser.pugx.org/d3catalyst/l4-resource-compress/license.svg)](https://packagist.org/packages/d3catalyst/l4-resource-compress)

Laravel 4 Library for calling http://cssminifier.com/ API.

This library provides an easy way to make the resource's optimizations, png, jpg, css adn javascript.

Just install the package, add the config and it is ready to use!

Requirements
============

* PHP >= 5.5.0
* cURL Extension

Installation
============

Add in composer.json
	"d3catalyst/l4-resource-compress"

Add the service provider and facade in your config/app.php

Service Provider

    'D3Catalyst\Compress\Laravel4\ServiceProviders\CompressServiceProvider'

Facade

	'Compress'           => 'D3Catalyst\Compress\Laravel4\Facades\Compress',

Usage
=====

Default uncompress and compressed resource path's.

	public_path('d3compress/full/')
	public_path('d3compress/min/')

Set diferent uncompressed path

	Compress::setUncompressedPath('new/path/uncompressed/')

Set diferent compressed path

	Compress::setUncompressedPath('new/path/compressed/')

Optimise PNG file

	Compress::png('image.png')

	return Array (
				    [mime_type] => image/png
				    [original_file] => /original/path/full/image.png
				    [optimized_file] => /original/path/min/image_opt.png
				    [original_zize] => 1078921
				    [optimized_zize] => 1067163
				)

Optimise lot of png images

	$pngImgLot = ['pngs/png1.png','pngs/png2.png','pngs/png3.png']

	Compress::pngLot($pngImgLot)

	return Array (
				    [pngs/png1.png] => Array
				        (
				            [mime_type] => image/png
				            [original_file] => /original/path/full/pngs/png1.png
				            [optimized_file] => /original/path/min/png1_opt.png
				            [original_zize] => 1078921
				            [optimized_zize] => 1067163
				        )

				    [pngs/png2.png] => Array
				        (
				            [mime_type] => image/png
				            [original_file] => /original/path/full/pngs/png2.png
				            [optimized_file] => /original/path/min/png2_opt.png
				            [original_zize] => 930396
				            [optimized_zize] => 884592
				        )

				    [pngs/png3.png] => Array
				        (
				            [mime_type] => image/png
				            [original_file] => /original/path/full/pngs/png3.png
				            [optimized_file] => /original/path/min/png3_opt.png
				            [original_zize] => 615815
				            [optimized_zize] => 592042
				        )

				)


Optimise JPG file

	Compress::jpg('image.png')

	return Array (
				    [mime_type] => image/jpeg
				    [original_file] => /original/path/full/image.jpg
				    [optimized_file] => /original/path/min/image_opt.jpg
				    [original_zize] => 1078921
				    [optimized_zize] => 1067163
				)

Optimise lot of jpg images

	$jpgImgLot = ['jpgs/jpg1.jpg','jpgs/jpg2.jpg','jpgs/jpg3.jpg']

	Compress::jpgLot($jpgImgLot)

	return Array (
				    [jpgs/jpg1.jpg] => Array
				        (
				            [mime_type] => image/jpeg
				            [original_file] => /original/path/full/jpgs/jpg1.jpg
				            [optimized_file] => /original/path/min/jpg1_opt.jpg
				            [original_size] => 904706
				            [optimized_size] => 904450
				        )

				    [jpgs/jpg2.jpg] => Array
				        (
				            [mime_type] => image/jpeg
				            [original_file] => /original/path/full/jpgs/jpg2.jpg
				            [optimized_file] => /original/path/min/jpg2_opt.jpg
				            [original_size] => 517780
				            [optimized_size] => 505848
				        )

				    [jpgs/jpg3.jpg] => Array
				        (
				            [mime_type] => image/jpeg
				            [original_file] => /original/path/full/jpgs/jpg3.jpg
				            [optimized_file] => /original/path/min/jpg3_opt.jpg
				            [original_size] => 382038
				            [optimized_size] => 381646
				        )

				)

Optimise CSS file

	Compress::css('style.css')

	return Array (
				    [mime_type] => text/plain
				    [original_file] => /original/path/style.css
				    [optimized_file] => /original/path/min/style.min.css
				    [original_zize] => 1078921
				    [optimized_zize] => 1067163
				)

Optimise lot of css files

	$cssLot = ['style1.css','style2.css','style2.css']

	Compress::cssLot($cssLot)

	return Array (
				    [style1.css] => Array
				        (
				            [mime_type] => text/plain
				            [original_file] => /original/path/full/style1.css
				            [optimized_file] => /original/path/min/style1.min.css
				            [original_size] => 9171
				            [optimized_size] => 7660
				        )

				    [style2.css] => Array
				        (
				            [mime_type] => text/plain
				            [original_file] => /original/path/full/style2.css
				            [optimized_file] => /original/path/min/style2.min.css
				            [original_size] => 104661
				            [optimized_size] => 86303
				        )

				    [style3.css] => Array
				        (
				            [mime_type] => text/plain
				            [original_file] => /original/path/full/style3.css
				            [optimized_file] => /original/path/min/style3.min.css
				            [original_size] => 243
				            [optimized_size] => 46
				        )

				)

Merge and compress css files

	$cssLot = ['style1.css','style2.css','style2.css']

	Compress::mergeCssLot($cssLot)

	return Array (
				    [mime_type] => text/plain
				    [original_file] => /original/path/full/b6a546c214c70710bf1d92df4bb305ed.css
				    [optimized_file] => /original/path/min/b6a546c214c70710bf1d92df4bb305ed.min.css
				    [original_size] => 113801
				    [optimized_size] => 88074
				)

	$cssLot = ['style1.css','style2.css','style2.css']

	Compress::mergeCssLot($cssLot, 'Othername')

	return Array (
				    [mime_type] => text/plain
				    [original_file] => /original/path/full/Othername.css
				    [optimized_file] => /original/path/min/Othername.min.css
				    [original_size] => 113801
				    [optimized_size] => 88074
				)

Optimise JS file

	Compress::js('script.js')

	return Array (
				    [mime_type] => text/plain
				    [original_file] => /original/path/script.js
				    [optimized_file] => /original/path/min/script.min.js
				    [original_zize] => 1078921
				    [optimized_zize] => 1067163
				)

Optimise lot of js files

	$jsLot = ['script1.js','script3.js','script3.js'];

	Compress::jsLot($jsLot)

	return Array (
				    [script1.js] => Array
				        (
				            [mime_type] => text/plain
				            [original_file] => /original/path/full/script1.js
				            [optimized_file] => /original/path/min/script1.min.js
				            [original_size] => 9171
				            [optimized_size] => 7660
				        )

				    [script2.js] => Array
				        (
				            [mime_type] => text/plain
				            [original_file] => /original/path/full/script2.js
				            [optimized_file] => /original/path/min/script2.min.js
				            [original_size] => 104661
				            [optimized_size] => 86303
				        )

				    [script3.js] => Array
				        (
				            [mime_type] => text/plain
				            [original_file] => /original/path/full/script3.js
				            [optimized_file] => /original/path/min/script3.min.js
				            [original_size] => 243
				            [optimized_size] => 46
				        )

				)

Merge and compress js files

	$jsLot = ['script1.js','script2.js','script2.js']

	Compress::mergeJsLot($jsLot)

	return Array (
				    [mime_type] => text/plain
				    [original_file] => /original/path/full/b6a546c214c70710bf1d92df4bb305ed.js
				    [optimized_file] => /original/path/min/b6a546c214c70710bf1d92df4bb305ed.min.js
				    [original_size] => 113801
				    [optimized_size] => 88074
				)

	$jsLot = ['script1.js','script2.js','script2.js']

	Compress::mergeJsLot($jsLot, 'Othername')

	return Array (
				    [mime_type] => text/plain
				    [original_file] => /original/path/full/Othername.js
				    [optimized_file] => /original/path/min/Othername.min.js
				    [original_size] => 113801
				    [optimized_size] => 88074
				)

If you want see debug info

	print_r(Compress::getDebugData())

See on fly error

	JPG

	if(Compress::jpg("file...")===false) {
		echo Compress::getErrorData();
	}

	PNG

	if(Compress::png("file...")===false) {
		echo Compress::getErrorData();
	}

	CSS

	if(Compress::css("file...")===false) {
		echo Compress::getErrorData();
	}

	JS

	if(Compress::js("file...")===false) {
		echo Compress::getErrorData();
	}

	JPG Lot

	if(Compress::jpgLot("array...")===false) {
		echo Compress::getErrorData();
	}

	PNG Lot

	if(Compress::pngLot("array...")===false) {
		echo Compress::getErrorData();
	}

	CSS Lot

	if(Compress::cssLot("array...")===false) {
		echo Compress::getErrorData();
	}

	Merge CSS Lot

	if(Compress::mergeCssLot("array...")===false) {
		echo Compress::getErrorData();
	}

	JS Lot

	if(Compress::jsLot("array...")===false) {
		echo Compress::getErrorData();
	}

	Merge JS Lot

	if(Compress::mergeJsLot("array...")===false) {
		echo Compress::getErrorData();
	}