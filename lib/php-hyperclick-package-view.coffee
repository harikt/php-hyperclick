path = require "path"
fs = require "fs"
child_process = require "child_process"

module.exports =
class PhpHyperclickPackageView
  constructor: (serializedState) ->
    # Create root element
    @element = document.createElement('div')
    @element.classList.add('php-hperclick-package')

    # Create message element
    message = document.createElement('div')
    message.textContent = "The PhpHyperclickPackage package is Alive! It's ALIVE!"
    message.classList.add('message')
    @element.appendChild(message)

  # Returns an object that can be retrieved when package is activated
  serialize: ->

  singleSuggestionProvider: =>
      providerName: 'php-hyperclick'
      getSuggestionForWord: (textEditor, text, range) ->
        {
          range: range
          callback: ->
            args = undefined
            ref1 = undefined
            ref2 = undefined
            relativePath = undefined
            projectPath = undefined
            # Get the current project path of the opened file. Thank you Dylan R. E. Moonfire
            # https://discuss.atom.io/t/project-folder-path-of-opened-file/24846/14?u=harikt
            ref2 = atom.project.relativizePath(textEditor.getPath())
            projectPath = ref2[0]
            args = [
              path.resolve __dirname, '../php/getfilepath.php'
              text
              textEditor.getPath()
              projectPath
            ]
            `openFilePath = child_process.spawnSync('php', args).output[1].toString('ascii')`

            try
              if fs.lstatSync(openFilePath).isFile()
                atom.workspace.open openFilePath
            catch error
              atom.notifications.addError 'Error : ' + openFilePath
            return
        }

  # Tear down any state and detach
  destroy: ->
    @element.remove()

  getElement: ->
    @element
