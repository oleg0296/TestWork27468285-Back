get_env () {

  #$1 = file
  #$2 = attribute
  cat $1 | grep $2= | cut -d '=' -f2

}

set_env () {

  #$1 = file
  #$2 = attribute
  #$3 = value

  #for linux
  #sed -i "s!$2=.*!$2=$3!g" "$1"

  #for mac os
  sed -i "" "s!$2=.*!$2=$3!g" "$1"

}

menu () {

  unset choices
  local options=("${!1}")

  local __resultvar=$2

  #Actions to take based on selection
  function ACTIONS {

    local i=0

    for index in ${!choices[*]}
    do
      if [[ ${choices[$index]} ]]; then
        eval $__resultvar[i]=${options[$index]}
        i=$((i+1))
      fi
    done
  }

  #Variables
  ERROR=" "

  #Clear screen for menu
  #clear

  #Menu function
  function MENU {
      #echo "Menu Options"
      # shellcheck disable=SC2068
      for NUM in ${!options[@]}; do
          echo "[""${choices[NUM]:- }""]" $(( NUM+1 ))") ${options[NUM]}"
      done
      echo "$ERROR"
  }

  #Menu loop
  while MENU && read -e -p "Select the desired options using their number (again to uncheck, ENTER when done): " -n1 SELECTION && [[ -n "$SELECTION" ]]; do
      clear
      if [[ "$SELECTION" == *[[:digit:]]* && $SELECTION -ge 1 && $SELECTION -le ${#options[@]} ]]; then
          (( SELECTION-- ))
          if [[ "${choices[SELECTION]}" == "+" ]]; then
              choices[SELECTION]=""
          else
              choices[SELECTION]="+"
          fi
              ERROR=" "
      else
          ERROR="Invalid option: $SELECTION"
      fi
  done

  ACTIONS

}

show_title () {
  echo -e "\e[32m########################### ##### ### #### ## ## ### ## ### # # ## # #\e[0m"
  echo -n -e "\e[32m#\e[0m";
  echo -e "\e[32m $1 ###### ## ### ## ## # ## # #\e[0m";
  echo -e "\e[32m####################\e[0m";
}

check_port () {
  local label=$1
  local port=$2
  local command=$(sudo netstat -lntup | grep ":$port")
  local __result=$3
  if [ -z "$command" ]
        then
          echo -e "\e[32m$label=$port\e[0m"
        else
          echo -e "\e[31m$label=$port (занят)\e[0m"
          echo -e "\e[31m$command\e[0m"
          echo -e "\e[31m---\e[0m"
          eval $__result=1
        fi
}



