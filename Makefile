
ifeq ($(OS),Windows_NT)
	CSSO = ./node_modules/.bin/csso.cmd
else
	CSSO = ./node_modules/.bin/csso
endif

ALL :
	php build.php icons/ data-uri > fam-flag.css
	php build.php icons/ url > fam-flag-std.css
	$(CSSO) fam-flag.css > fam-flag.min.css
	$(CSSO) fam-flag-std.css > fam-flag-std.min.css
