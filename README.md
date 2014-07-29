laravel-4-resource-compress
===============

[![Build Status](https://travis-ci.org/D3Catalyst/laravel-4-resource-compress.svg?branch=master)](https://travis-ci.org/D3Catalyst/laravel-4-resource-compress) [![Latest Stable Version](https://poser.pugx.org/d3catalyst/l4-resource-compress/v/stable.svg)](https://packagist.org/packages/d3catalyst/l4-resource-compress) [![Total Downloads](https://poser.pugx.org/d3catalyst/l4-resource-compress/downloads.svg)](https://packagist.org/packages/d3catalyst/l4-resource-compress) [![Latest Unstable Version](https://poser.pugx.org/d3catalyst/l4-resource-compress/v/unstable.svg)](https://packagist.org/packages/d3catalyst/l4-resource-compress) [![License](https://poser.pugx.org/d3catalyst/l4-resource-compress/license.svg)](https://packagist.org/packages/d3catalyst/l4-resource-compress) ![stable](http://img.shields.io/badge/stable-v%201.0.0-blue.svg)

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

Set uncompressed path

	Compress::setUncompressedPath('new/path/uncompressed/')

Set compressed path

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
	