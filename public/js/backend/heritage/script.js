/*
 * https://tristandenyer.com/demos/dynamic-form.html
 */
$(function () {
    $('#add_name').click(function () {
        var num = $('.clonedInput_1').length, // Checks to see how many "duplicatable" input fields we currently have
            newNum = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
            newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value

        // Label for name field
        newElem.find('.label_name').attr('id', 'ID' + newNum + '_reference').attr('name', 'ID' + newNum + '_reference').html($('#entry1').find('.label_name').html() + ' #' + newNum);
        // Name input - text
        newElem.find('.input_name').attr('id', 'ID' + newNum + '_name').attr('name', 'name[]').val('');
        // From input - datetime
        newElem.find('.input_date_from').attr('id', 'ID' + newNum + '_date_from').attr('name', 'date_from[]').val('').removeAttr('required');
        // To input - datetime
        newElem.find('.input_date_to').attr('id', 'ID' + newNum + '_date_to').attr('name', 'date_to[]').val($('#entry'+num).find('.input_date_from').val()).removeAttr('required');
        // Radio
        newElem.find('.current_name').attr('id', 'ID' + newNum + '_current').attr('name', 'current_name').val(num);

        // Insert the new element after the last "duplicatable" input field
        $('#entry' + num).after(newElem);
        $('#ID' + newNum + '_name').focus();

        // Enable the "remove" button. This only shows once you have a duplicated section.
        $('#del_name').attr('disabled', false);

        // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
        // This first if statement is for forms using input type="button" (see older demo). Delete if using button element.
        if (newNum == 5)
            $('#add_name').attr('disabled', true).prop('value', "You've reached the limit"); // value here updates the text in the 'add' button when the limit is reached
        // This second if statement is for forms using the new button tag (see Bootstrap demo). Delete if using input type="button" element.
        if (newNum == 5)
            $('#add_name').attr('disabled', true).text("You've reached the limit"); // value here updates the text in the 'add' button when the limit is reached

        $(":input").inputmask();
        $('.datepicker').datepicker({
            autoclose: true
        })
    });

    $('#del_name').click(function () {
        // Confirmation dialog box. Works on all desktop browsers and iPhone.
        if (confirm("Are you sure you wish to remove this name? This cannot be undone.")) {
            var num = $('.clonedInput_1').length;
            // how many "duplicatable" input fields we currently have
            $('#entry' + num).slideUp('slow', function () {
                $(this).remove();
                // if only one element remains, disable the "remove" button
                if (num - 1 === 1)
                    $('#del_name').attr('disabled', true);
                // enable the "add" button. IMPORTANT: only for forms using input type="button" (see older demo). DELETE if using button element.
                $('#add_name').attr('disabled', false).prop('value', "+ Add name");
                // enable the "add" button. IMPORTANT: only for forms using the new button tag (see Bootstrap demo). DELETE if using input type="button" element.
                $('#add_name').attr('disabled', false).text("+ Add name");
            });
        }
        return false; // Removes the last section you added
    });
    // Enable the "add" button
    $('#add_name').attr('disabled', false);
    // Disable the "remove" button
    $('#del_name').attr('disabled', true);

    /////////////
    $('#add_type').click(function () {
        var num = $('.clonedType_1').length, // Checks to see how many "duplicatable" input fields we currently have
            newNum = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
            newElem = $('#entryType' + num).clone().attr('id', 'entryType' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value

        /*  This is where we manipulate the name/id values of the input inside the new, cloned element
         Below are examples of what forms elements you can clone, but not the only ones.
         There are 2 basic structures below: one for an H2, and one for form elements.
         To make more, you can copy the one for form elements and simply update the classes for its label and input.
         Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
         */
        // Label for email field
        newElem.find('.label_type').attr('id', 'ID' + newNum + '_type_reference').attr('name', 'ID' + newNum + '_type_reference').html($('#entryType1').find('.label_type').html() + ' #' + newNum);
        // Email input - text
        newElem.find('.input_type').attr('id', 'ID' + newNum + '_type').attr('name', 'property_type[]').val('');
        // From input - datetime
        newElem.find('.input_type_date_from').attr('id', 'ID' + newNum + '_date_from').attr('name', 'property_type_date_from[]').val('').removeAttr('required');
        // To input - datetime
        newElem.find('.input_type_date_to').attr('id', 'ID' + newNum + '_date_to').attr('name', 'property_type_date_to[]').val($('#entryType'+num).find('.input_date_from').val()).removeAttr('required');
        // Radio
        newElem.find('.current_type').attr('id', 'ID' + newNum + '_current').attr('name', 'current_type').val(num);

        // Insert the new element after the last "duplicatable" input field
        $('#entryType' + num).after(newElem);
        $('#ID' + newNum + '_type').focus();

        // Enable the "remove" button. This only shows once you have a duplicated section.
        $('#del_type').attr('disabled', false);

        // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
        // This first if statement is for forms using input type="button" (see older demo). Delete if using button element.
        if (newNum == 5)
            $('#add_type').attr('disabled', true).prop('value', "You've reached the limit"); // value here updates the text in the 'add' button when the limit is reached
        // This second if statement is for forms using the new button tag (see Bootstrap demo). Delete if using input type="button" element.
        if (newNum == 5)
            $('#add_type').attr('disabled', true).text("You've reached the limit"); // value here updates the text in the 'add' button when the limit is reached

        $(":input").inputmask();
        $('.datepicker').datepicker({
            autoclose: true
        })
    });

    $('#del_type').click(function () {
        // Confirmation dialog box. Works on all desktop browsers and iPhone.
        if (confirm("Are you sure you wish to remove this property type? This cannot be undone.")) {
            var num = $('.clonedType_1').length;
            // how many "duplicatable" input fields we currently have
            $('#entryType' + num).slideUp('slow', function () {
                $(this).remove();
                // if only one element remains, disable the "remove" button
                if (num - 1 === 1)
                    $('#del_type').attr('disabled', true);
                // enable the "add" button. IMPORTANT: only for forms using input type="button" (see older demo). DELETE if using button element.
                $('#add_type').attr('disabled', false).prop('value', "+ Add name");
                // enable the "add" button. IMPORTANT: only for forms using the new button tag (see Bootstrap demo). DELETE if using input type="button" element.
                $('#add_type').attr('disabled', false).text("+ Add name");
            });
        }
        return false; // Removes the last section you added
    });
    // Enable the "add" button
    $('#add_type').attr('disabled', false);
    // Disable the "remove" button
    $('#del_type').attr('disabled', true);
});

