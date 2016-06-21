# Linky (previously: The Whale)

This project began as a coding exercise for a course I’m teaching this semester, serializing Moby Dick serialized into tiny texts. I’ve since renamed and expanded the project to include other source texts.

## Texts from Project Gutenberg

* [Jane Eyre](https://www.gutenberg.org/ebooks/1260) by Charlotte Brontë
* [Don Quixote](https://www.gutenberg.org/ebooks/996) by Miguel de Cervantes Saavedra
* [A Christmas Carol](https://www.gutenberg.org/ebooks/46) by Charles Dickens
* [Siddhartha](https://www.gutenberg.org/ebooks/2500) by Hermann Hesse
* [Le Morte D’Arthur](https://www.gutenberg.org/ebooks/1251) by Thomas Malory
* [Moby Dick](https://www.gutenberg.org/ebooks/2701) by Herman Melville
* [Frankenstein](http://www.gutenberg.org/ebooks/84) by Mary Shelley
* [Twenty Thousand Leagues Under the Sea](https://www.gutenberg.org/ebooks/164) by Jules Verne
* [A Journey to the Centre of the Earth](https://www.gutenberg.org/ebooks/18857) by Jules Verne
* [The Time Machine](http://www.gutenberg.org/ebooks/35) by H. G. Wells

The source texts have been slightly modified prior to breaking them into many smaller text files. For example, I’ve deleted introductory and preface text and converted double-hyphens into em-dashes. I also converted `\r\n` Windows-style line breaks to `\n` Unix-style line breaks.

## Auto-advance

Add `?wait=15` to the URL to auto-advance forward every 15 seconds.

## Preparing the .txt files

Run `linky.php` to break a source into tiny text files.

## Design based on BOIYNB

The text treatment is based on [Mat Honan’s](http://www.honan.net/) iconic [Barack Obama Is Your New Bicycle](http://barackobamaisyournewbicycle.com/).
