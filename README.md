# NewOCR

This is a very simple wrapper I made for NewOCR.com

You can get an API key at [http://www.newocr.com/api/]

[http://www.newocr.com/api/]: http://www.newocr.com/api/

## Setup
Setup is very quick and painless. 

First you must include the main class.
You can also use composer to do this:
```
{
    "require": {
        "kevc45/newocr": "dev-master"
    }
}
```
Now all you need to do is pass your API api to "OCR".

## Usage
You can use this one line to upload the file "test.png" and get the text from it:
```
$OCR->get_text('test.png');
```
Also see the example files.

## License
The MIT License (MIT)

Copyright (c) 2014 Kevin Cushman

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
