<table style="width:100%; font-size: 13px;">
	<tr>
		<th align="left">attribute</th>
		<th align="left">description</th>
		<th align="left">default value</th>
	</tr>
	<tr>
		<td>before</td>
		<td>Displayed before the link to the child theme</td>
		<td>Empty string</td>
	</tr>
	<tr>
		<td>after</td>
		<td>Displayed after the link to the child theme</td>
		<td>Empty string</td>
	</tr>
    <tr>
        <td>span-class</td>
        <td>Additional classes to add to the span element</td>
        <td>Empty string</td>
    </tr>
    <tr>
        <td>span-style</td>
        <td>Inline CSS to style the span element</td>
        <td>Empty string</td>
    </tr>
    <tr>
        <td>link-class</td>
        <td>Additional classes to add to the anchor link element</td>
        <td>Empty string</td>
    </tr>
    <tr>
        <td>link-style</td>
        <td>Inline CSS to style the anchor link element</td>
        <td>Empty string</td>
    </tr>
	<tr>
		<td>child-theme-name</td>
		<td>Name of the child theme</td>
		<td>CHILD_THEME_NAME</td>
	</tr>
    <tr>
        <td>child-theme-url</td>
        <td>URL of the child theme</td>
        <td>CHILD_THEME_URL</td>
    </tr>
</table>
<p>
If CHILD_THEME_NAME or CHILD_THEME_URL constants are not defined then the shortcode is disabled.</br>
If they are defined, their attribute values as a default may be overridden with alternative values to output.
</p>


