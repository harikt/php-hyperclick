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
            var args, ref1, ref2, relativePath, projectPath;

            // Get the current project path of the opened file. Thank you Dylan R. E. Moonfire
            // https://discuss.atom.io/t/project-folder-path-of-opened-file/24846/14?u=harikt
            ref2 = atom.project.relativizePath(textEditor.getPath());
            projectPath = ref2[0];

            args = [
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
