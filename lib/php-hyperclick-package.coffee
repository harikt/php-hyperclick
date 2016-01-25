PhpHyperclickPackageView = require './php-hyperclick-package-view'
{CompositeDisposable} = require 'atom'

module.exports = PhpHyperclickPackage =
  phpHyperclickPackageView: null
  modalPanel: null
  subscriptions: null

  activate: (state) ->
    @phpHyperclickPackageView = new PhpHyperclickPackageView(state.phpHyperclickPackageViewState)
    # Events subscribed to in atom's system can be easily cleaned up with a CompositeDisposable
    @subscriptions = new CompositeDisposable

  getProvider: ->
    @phpHyperclickPackageView.singleSuggestionProvider()

  deactivate: ->
    @subscriptions.dispose()
    @phpHyperclickPackageView.destroy()

  serialize: ->
    phpHyperclickPackageViewState: @phpHyperclickPackageView.serialize()
