"""
Maelstrom - visualizing email contacts

Copyright(c) 2008-2009 Stefan Marsiske <my name at gmail.com>
"""

import email

def decode_header(text):
   """Decode a header value and return the value as a unicode string."""
   if not text:
       return text
   res = []
   for part, charset in email.Header.decode_header(text):
      try:
         res.append(part.decode(charset or 'latin1', 'replace'))
      except LookupError: # If charset is unknown
         res.append(part.decode('latin1', 'replace'))
   return ' '.join(res)
