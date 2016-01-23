"use babel";
import cp from 'child_process';
import path from 'path';
// import "process"
import { CompositeDisposable } from 'atom'

var singleSuggestionProvider = {
    providerName:'php-hyperclick',
    getSuggestionForWord(textEditor: TextEditor, text: string, range: Range): HyperclickSuggestion {
        return {
          range,
          callback() {
            // const {openExternal} = require('shell');
            // openExternal('http://google.com');
            var directory, currentFile, filepath, projectPath, i, len, ref;

            ref = atom.project.getDirectories();
            currentFile = path.dirname(textEditor.getPath());
            projectPath = '';
            for (i = 0, len = ref.length; i < len; i++) {
              directory = ref[i];
              if (currentFile.indexOf(directory.path) > -1) {
                  projectPath = directory.path;
              }
            }

            var args = [
                path.resolve(__dirname, '../php/getfilepath.php'),
                text,
                textEditor.getPath(),
                projectPath
            ];
            openFilePath = cp.spawnSync('php', args).output[1].toString('ascii');
            if (openFilePath) {
                atom.workspace.open(openFilePath);
            } else {
                atom.notifications.addInfo('Unable to locate , errored with ' + openFilePath);
            }
          },
        };
    }
}

module.exports = {
    activate(state) {
        this.subscriptions = new CompositeDisposable()
    },
    getProvider() {
        return singleSuggestionProvider;
    },
    deactivate() {
        this.subscriptions.dispose()
    }
};
