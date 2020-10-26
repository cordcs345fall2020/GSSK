#include <iostream>
using namespace std;

int main()
{
   int i, x;
   char str[100];

   cout << "String:\t";
   cin >> str;

   cout << "1.Encrypt the string.\n";
   cout << "2.Decrypt the string.\n";
   cin >> x;

   switch(x)
   {
      case 1:
         for(i = 0; (i < 100 && str[i] != '\0'); i++)
            str[i] = str[i] + 2;

         cout << "\nEncrypted string: " << str << endl;
         break;

      case 2:
         for(i = 0; (i < 100 && str[i] != '\0'); i++)
         str[i] = str[i] - 2;

      cout << "\nDecrypted string: " << str << endl;
      break;

      default:
         cout << "\nInvalid Input !!!\n";
   }
   return 0;
}
