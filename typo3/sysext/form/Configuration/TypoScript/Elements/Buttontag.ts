plugin.tx_form {
		# elementPartials
		# Used by: frontend, wizard (not implemented right now)
		# Overwritable by user: FALSE
		#
		# Defines the template selection array for the form wizard.
		# Each defined item is shown as option within the wizard.
		#
		# If there is no partialPath property in the userdefined TypoScript
		# then elementPartials.ELEMENTNAME.10.partialPath is the default.
	view {
		elementPartials {
			BUTTONTAG {
				10 {
					displayName = Default
					partialPath = FlatElements/ButtonTag
				}
			}
		}
	}

	settings {
		registeredElements {
				# BUTTONTAG
				# Used by: frontend, wizard (not implemented right now)
				# Used ViewHelper: f:form.button
				#
				# Generates an element <button type="..." />
			BUTTONTAG {
					# htmlAttributes
					# Used by: frontend, wizard (not implemented right now)
					# Overwritable by user: FALSE
					#
					# Defines allowed HTML attributes for a specific element.
					# Based on selfhtml documentation version 8.1.2 (see http://wiki.selfhtml.org/wiki/Referenz:HTML/).
					# This is needed to detect and map these strings within the user configured element definition as HTML attributes.
					# As soon as prefix-* is defined every attribute is registered automatically as HTML attribute.
				htmlAttributes {
						# generic attributes
					10 = id
					20 = class
					30 = accesskey
					40 = contenteditable
					50 = contextmenu
					60 = dir
					70 = draggable
					80 = dropzone
					90 = hidden
					100 = lang
					110 = spellcheck
					120 = style
					130 = tabindex
					140 = title
					150 = data-*
					160 = translate
						# element specific attributes
					200 = autofocus
					210 = disabled
					220 = name
					230 = type
					240 = value
				}

					# htmlAttributesUsedByTheViewHelperDirectly
					# Used by: frontend
					# Overwritable by user: FALSE
					#
					# Each HTML attribute defined at ".htmlAttributes" is available as array within the model.
					# This array will be added to the resulting HTML tag.
					# For this purpose the Fluid argument "additionalAttributes" of the ViewHelper is used.
					#
					# Some HTML attributes have to be assigned directly as an argument to the ViewHelper.
					# The htmlAttributesUsedByTheViewHelperDirectly map is used to remove the specified
					# HTML attribute from the "htmlAttributes" array and sets it for the model's "additionalArguments" array.
					#
					# There are two attributes which special behavior:
					# 	* disabled
					#	* readonly
					# These attributes can be assigned to the most ViewHelpers but whenever a "disabled" attribute appears
					# the browser will disable this element no matter of the value.
					# See: https://forge.typo3.org/issues/42474
					# Therefore it is held in the htmlAttributes array and the code removes this attribute if its value is set to 0.
				htmlAttributesUsedByTheViewHelperDirectly {
						# generic attributes
					10 = class
					20 = dir
					30 = id
					40 = lang
					50 = style
					60 = title
					70 = accesskey
					80 = tabindex
					100 = name
					110 = value
						# ButtonViewHelper
					120 = autofocus
					130 = type
				}

					# defaultHtmlAttributeValues
					# Used by: frontend, wizard (not implemented right now)
					# Overwritable by user: FALSE
					#
					# The following values are automatically set if there is no entry in the user configured element.
				defaultHtmlAttributeValues {
					type = button
				}

					# partialPath
					# Used by: frontend, wizard (not implemented right now)
					# Overwritable by user: TRUE
					#
					# The defined partial is used to render the element.
					# The partial paths to the element are build based on the following rule:
					# {$plugin.tx_form.view.partialRootPath}/{$themeName}/@actionName/{$partialPath}.
				partialPath =< plugin.tx_form.view.elementPartials.BUTTONTAG.10.partialPath

					# visibleInShowAction
					# Used by: frontend
					# Overwritable by user: TRUE
					#
					# If set to 1 this element is displayed in the form.
					# @ToDo: add more details
				visibleInShowAction = 1

					# visibleInConfirmationAction
					# Used by: frontend
					# Overwritable by user: TRUE
					#
					# If set to 1 this element is displayed in the confirmation page.
					# @ToDo: add more details
				visibleInConfirmationAction = 0

					# visibleInProcessAction
					# Used by: frontend
					# Overwritable by user: TRUE
					#
					# If set to 1 this element is displayed in the mail.
					# @ToDo: add more details
				visibleInMail = 0
			}
		}
	}
}
