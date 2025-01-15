jQuery(document).ready(function($) {
    const $previewDiv = $('#skst-preview');
    const newContent = `
                      <div id="skst-preview-button">
                        <span class="icon"> &uarr;</span>
                      </div>
                    `;
    $previewDiv.append(newContent);
    function updatePreview() {
        let iconSize = $('#icon_size').val();
        let backgroundColor = $('#background_color').val();
        let iconColor = $('#icon_color').val();
        let buttonWidth = $('#button_width').val();
        let buttonHeight = $('#button_height').val();
        let borderRadius = $('#button_border_radius').val();
        let buttonPosition = $('#button_position').val();
        let buttonPositionX = $('#button_position_x').val();
        let buttonPositionY = $('#button_position_y').val();
        const $button = $('#skst-preview-button');
        $button.css({
            backgroundColor:backgroundColor,
            color:iconColor,
            width: `${buttonWidth}px`,
            height: `${buttonHeight}px`,
            borderRadius: `${borderRadius}px`,
            position: 'absolute',
            [buttonPosition.includes('left') ? 'left' : 'right']: `${buttonPositionX}px`,
            bottom: `${buttonPositionY}px`,
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center',
            cursor: 'pointer'

        });
        $button.find('span').css({
            fontSize: `${iconSize}px`,
            fontWeight: 'bold'
        });
    }
    $('input, select').on('input change', updatePreview);
    updatePreview();
});
