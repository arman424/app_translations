# File Translator

Please follow the instructions for using the project.
As a first step you need to clone the project, then run ``composer install``.

For translations you can apply any API (there is no implementation for the translations).

- Create 2 files ``input.txt`` and ``output.txt`` (keep it empty)
- Make a new directory - ``public/assets/files`` and place the files there.
  ![image](https://github.com/arman424/app_translations/assets/137682392/3bf4ac57-7bdb-4975-8058-a825fba41d01)
- In the ``input.txt`` enter the text that needs to be translated. Translations will be transferred to the ``output.txt``.
- Run the command: ``php bin/console file:translate input.txt output.txt fr``. The command name is ``file:translate``, as the first argument you should pass the name of the file that needs to be translated, and the second argument should be the name of the file where the translations should be stored. As the third argument, you should pass the language you want to translate to.
